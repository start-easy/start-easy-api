<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class QuestionnaireService
{
    // Make questionnaireConfig nullable
    protected ?Collection $questionnaireConfig = null;
    protected Collection $activitiesConfig;
    protected array $processedAnswers = [];
    protected array $summaryFormAnswers = [];
    protected array $textInputAnswers = [];

    public function __construct()
    {
        // Config is now loaded in processAnswers() or getStepTitle()
    }

    /**
     * Loads the configuration files based on the provided locale.
     *
     * @param string $locale
     */
    protected function loadConfig(string $locale): void
    {
        $questionnaireFile = 'questionnaireData' . ($locale === 'ar' ? 'Ar' : '') . '.json';
        $activitiesFile = 'activitiesData' . ($locale === 'ar' ? 'Ar' : '') . '.json';

        $this->questionnaireConfig = collect(json_decode(File::get(base_path("app/data/{$questionnaireFile}")), true))->keyBy('id');
        $this->activitiesConfig = collect(json_decode(File::get(base_path("app/data/{$activitiesFile}")), true));
    }

    /**
     * Helper function to get a specific step's title.
     *
     * @param string $stepId
     * @param string $locale
     * @return string
     */
    public function getStepTitle(string $stepId, string $locale): string
    {
        // Ensure config is loaded if it hasn't been already
        if (!$this->questionnaireConfig) {
            $this->loadConfig($locale);
        }
        $stepConfig = $this->questionnaireConfig->get($stepId);
        return $stepConfig['title'] ?? '';
    }

    /**
     * Processes the raw answers from the frontend, resolves labels,
     * merges linked steps, and separates data for email and PDF.
     *
     * @param array $rawAnswers The array of raw answers from the frontend.
     * @param string $locale The current locale (e.g., 'en' or 'ar').
     * @return array Contains 'processed_data_for_pdf' and 'email_data_summary'.
     */
    public function processAnswers(array $rawAnswers, string $locale): array
    {
        // Load the correct language files if not already loaded
        if (!$this->questionnaireConfig) {
            $this->loadConfig($locale);
        }

        $this->processedAnswers = [];
        $this->summaryFormAnswers = [];
        $this->textInputAnswers = [];

        $rawAnswersMap = collect($rawAnswers)->keyBy('stepId');

        foreach ($rawAnswers as $rawAnswer) {
            $stepId = $rawAnswer['stepId'];
            $answerValue = $rawAnswer['answer'];
            $stepConfig = $this->questionnaireConfig->get($stepId);

            if (!$stepConfig) {
                continue;
            }

            $stepType = $stepConfig['type'];
            $stepLabel = $stepConfig['title']; // This will be in the correct language

            switch ($stepType) {
                case 'radio':
                    $selectedOption = collect($stepConfig['options'])->firstWhere('value', $answerValue);
                    $this->processedAnswers[] = [
                        'label' => $stepLabel,
                        'value' => $selectedOption ? $selectedOption['label'] : 'N/A' // Label is now localized
                    ];
                    break;

                case 'checkbox':
                    if ($stepId === 'step2_1' && isset($stepConfig['data_linked_step'])) {
                        $linkedStepId = $stepConfig['data_linked_step'];
                        $linkedRawAnswer = $rawAnswersMap->get($linkedStepId);

                        if ($linkedRawAnswer && $this->questionnaireConfig->get($linkedStepId)['type'] === 'activities') {
                            $mergedActivities = [];
                            $othersToggled = $linkedRawAnswer['answer']['othersToggled'] ?? [];

                            foreach ($answerValue as $sectorValue) {
                                $sectorOption = collect($stepConfig['options'])->firstWhere('value', $sectorValue);
                                $sectorLabel = $sectorOption['label'] ?? $sectorValue; // Localized label

                                $activitiesForSector = $linkedRawAnswer['answer'][$sectorValue] ?? [];
                                $activityLabels = [];

                                if ($sectorValue === 'others') {
                                    $allActivities = $this->activitiesConfig->flatten(1);
                                    foreach ($activitiesForSector as $activityValue) {
                                        $activityLabel = collect($allActivities)->firstWhere('value', $activityValue)['label'] ?? $activityValue;
                                        $activityLabels[] = $activityLabel; // Localized label
                                    }
                                } else {
                                    $activitiesInConfig = $this->activitiesConfig->get($sectorValue) ?? [];
                                    foreach ($activitiesForSector as $activityValue) {
                                        $activityLabel = collect($activitiesInConfig)->firstWhere('value', $activityValue)['label'] ?? $activityValue;
                                        $activityLabels[] = $activityLabel; // Localized label
                                    }
                                }
                                if (in_array($sectorValue, $othersToggled, true)) {
                                    if ($sectorValue === 'others') {
                                        $activityLabels[] = $locale === 'ar' ? 'بحاجة الى نصيحة' : 'Need advice';
                                    } else {
                                        $activityLabels[] = $locale === 'ar' ? 'أخرى/غير مدرجة' : 'Other/Not listed';
                                    }
                                }
                                $mergedActivities[$sectorLabel] = $activityLabels;
                            }

                            $this->processedAnswers[] = [
                                'label' => $stepLabel,
                                'value' => $mergedActivities
                            ];
                        }
                    } else {
                        $selectedLabels = [];
                        foreach ($answerValue as $val) {
                            $option = collect($stepConfig['options'])->firstWhere('value', $val);
                            if ($option) {
                                $selectedLabels[] = $option['label']; // Localized label
                            }
                        }
                        $this->processedAnswers[] = [
                            'label' => $stepLabel,
                            'value' => implode(', ', $selectedLabels)
                        ];
                    }
                    break;

                case 'checkbox_with_input':
                    $selectedLabels = [];
                    $selectedValues = [];

                    if (isset($answerValue['selected']) && is_array($answerValue['selected'])) {
                        $selectedValues = $answerValue['selected'];
                    } elseif (is_array($answerValue)) {
                        $selectedValues = $answerValue;
                    }

                    foreach ($selectedValues as $val) {
                        $option = collect($stepConfig['options'])->firstWhere('value', $val);
                        if ($option) {
                            $selectedLabels[] = $option['label']; // Localized label
                        }
                    }

                    $this->processedAnswers[] = [
                        'label' => $stepLabel,
                        'value' => implode(', ', $selectedLabels)
                    ];

                    if (isset($stepConfig['extraInput']['id'])) {
                        $extraInputId = $stepConfig['extraInput']['id'];
                        if (is_array($answerValue) && !empty($answerValue[$extraInputId])) {
                            $this->processedAnswers[] = [
                                'label' => $stepConfig['extraInput']['label'], // Localized label
                                'value' => $answerValue[$extraInputId]
                            ];
                        }
                    }
                    break;

                case 'text':
                    $fieldLabelsAndValues = [];
                    $fieldNamesAndValues = [];
                    foreach ($stepConfig['fields'] as $field) {
                        if (isset($answerValue[$field['name']])) {
                            $fieldLabelsAndValues[$field['label']] = $answerValue[$field['name']];
                            $fieldNamesAndValues[$field['name']] = $answerValue[$field['name']];
                        }
                    }
                    $this->processedAnswers[] = [
                        'label' => $stepLabel,
                        'value' => $fieldLabelsAndValues // This goes to PDF
                    ];
                    $this->textInputAnswers = array_merge($this->textInputAnswers, $fieldNamesAndValues); // This goes to Email
                    break;

                case 'summary_form':
                    $fieldLabelsAndValues = [];
                    $fieldNamesAndValues = [];
                    foreach ($stepConfig['fields'] as $field) {
                        if (isset($answerValue[$field['name']])) {
                            $fieldLabelsAndValues[$field['label']] = $answerValue[$field['name']];
                            $fieldNamesAndValues[$field['name']] = $answerValue[$field['name']];
                        }
                    }
                    $this->processedAnswers[] = [
                        'label' => $stepLabel,
                        'value' => $fieldLabelsAndValues // This goes to PDF
                    ];
                    $this->summaryFormAnswers = array_merge($this->summaryFormAnswers, $fieldNamesAndValues); // This goes to Email
                    break;

                case 'activities':
                    break;
            }
        }

        $this->processedAnswers = array_filter($this->processedAnswers, function ($item) {
            $step2_2_config = $this->questionnaireConfig->get('step2_2');
            if ($step2_2_config && $item['label'] === $step2_2_config['title'] && is_array($item['value'])) {
                return false;
            }
            return true;
        });

        return [
            'processed_data_for_pdf' => array_values($this->processedAnswers),
            'email_data_summary' => array_merge($this->textInputAnswers, $this->summaryFormAnswers) // Now name-keyed
        ];
    }
}
