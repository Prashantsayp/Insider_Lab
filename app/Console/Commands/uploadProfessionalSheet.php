<?php

namespace App\Console\Commands;

use Excel;
use Illuminate\Console\Command;
use App\Imports\ProfessionalImport;
use App\Models\ProfessionalPolicyDetails;
use Illuminate\Support\Facades\Storage;

class uploadProfessionalSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'professional:upload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to upload the data on the server.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return 0;

        $path = Storage::disk("public")->allFiles();
        // print_r($path);
        foreach ($path as $pKey => $pValue) {
            if ($pValue == "ProfessionalLoanAnalyticsFinal.xls") {
                $allSheetData = Excel::toArray(new ProfessionalImport, storage_path('app/public/ProfessionalLoanAnalyticsFinal.xls'));
                // print_r($allSheetData);
                foreach ($allSheetData as $sheetNumber => $sheetData) {
                    foreach ($sheetData as $rowNumber => $rowData) {
                        echo PHP_EOL;
                        print_r($rowData);
                        $count = 0;
                        if (isset($rowData[8])) {
                            $professionalPolicy1 = new ProfessionalPolicyDetails();

                            $professionalPolicy1->policy_id = 1;
                            $professionalPolicy1->calculation_field = "foir";
                            $professionalPolicy1->linked_condition_key = "profile";
                            $professionalPolicy1->condition = "equals_to";
                            $professionalPolicy1->condition_type = "and";
                            $professionalPolicy1->condition_value = $rowData[0];
                            $professionalPolicy1->save();


                            $professionalPolicy2 = new ProfessionalPolicyDetails();

                            $professionalPolicy2->policy_id = 1;
                            $professionalPolicy2->calculation_field = "foir";
                            $professionalPolicy2->linked_condition_key = "employment_type";
                            $professionalPolicy2->condition = "equals_to";
                            $professionalPolicy2->condition_type = "and";
                            $professionalPolicy2->condition_value = $rowData[1];
                            $professionalPolicy2->parent_condition_id = $professionalPolicy1->id;
                            $professionalPolicy2->parent_condition_value = $professionalPolicy1->condition_value;
                            $professionalPolicy2->save();


                            $professionalPolicy3 = new ProfessionalPolicyDetails();

                            $professionalPolicy3->policy_id = 1;
                            $professionalPolicy3->calculation_field = "foir";
                            $professionalPolicy3->linked_condition_key = "experience";
                            $professionalPolicy3->condition = "greater_than_equals_to";
                            $professionalPolicy3->condition_type = "and";
                            $professionalPolicy3->condition_value = $rowData[2];
                            $professionalPolicy3->parent_condition_id = $professionalPolicy2->id;
                            $professionalPolicy3->parent_condition_value = $professionalPolicy2->condition_value;
                            $professionalPolicy3->save();


                            $professionalPolicy4 = new ProfessionalPolicyDetails();

                            $professionalPolicy4->policy_id = 1;
                            $professionalPolicy4->calculation_field = "foir";
                            $professionalPolicy4->linked_condition_key = "loan_amount";
                            $professionalPolicy4->condition = "in_range";
                            $professionalPolicy4->condition_type = "and";
                            $professionalPolicy4->condition_value = $rowData[3];
                            $professionalPolicy4->parent_condition_id = $professionalPolicy3->id;
                            $professionalPolicy4->parent_condition_value = $professionalPolicy3->condition_value;
                            $professionalPolicy4->save();


                            $professionalPolicy5 = new ProfessionalPolicyDetails();

                            $professionalPolicy5->policy_id = 1;
                            $professionalPolicy5->calculation_field = "foir";
                            $professionalPolicy5->final_value = $rowData[8];
                            $professionalPolicy5->linked_condition_key = "ownership_status";
                            $professionalPolicy5->condition = "equals_to";
                            $professionalPolicy5->condition_type = "and";
                            $professionalPolicy5->condition_value = $rowData[4];
                            $professionalPolicy5->parent_condition_id = $professionalPolicy4->id;
                            $professionalPolicy5->parent_condition_value = $professionalPolicy4->condition_value;
                            $professionalPolicy5->save();
                            /**
                             *  'policy_id' => '1',
                             *  'linked_condition_key' => 'profile',
                             *  'condition' => 'equals_to',
                             *  'condition_value' => 'string',
                             *  'condition_type' => 'string',
                             *  'parent_condition_id' => 'integer',
                             *  'parent_condition_value' => 'string',
                             *  'calculation_field' => 'foir',
                             *  'final_value' => 'string'
                             */
                        }
                        else {
                            $professionalPolicy1 = new ProfessionalPolicyDetails();

                            $professionalPolicy1->policy_id = 1;
                            $professionalPolicy1->calculation_field = "cash_profit_program";
                            $professionalPolicy1->linked_condition_key = "profile";
                            $professionalPolicy1->condition = "equals_to";
                            $professionalPolicy1->condition_type = "and";
                            $professionalPolicy1->condition_value = $rowData[0];
                            $professionalPolicy1->save();


                            $professionalPolicy2 = new ProfessionalPolicyDetails();

                            $professionalPolicy2->policy_id = 1;
                            $professionalPolicy2->calculation_field = "cash_profit_program";
                            $professionalPolicy2->linked_condition_key = "employment_type";
                            $professionalPolicy2->condition = "equals_to";
                            $professionalPolicy2->condition_type = "and";
                            $professionalPolicy2->condition_value = $rowData[1];
                            $professionalPolicy2->parent_condition_id = $professionalPolicy1->id;
                            $professionalPolicy2->parent_condition_value = $professionalPolicy1->condition_value;
                            $professionalPolicy2->save();


                            $professionalPolicy3 = new ProfessionalPolicyDetails();

                            $professionalPolicy3->policy_id = 1;
                            $professionalPolicy3->calculation_field = "cash_profit_program";
                            $professionalPolicy3->linked_condition_key = "experience";
                            $professionalPolicy3->condition = "greater_than_equals_to";
                            $professionalPolicy3->condition_type = "and";
                            $professionalPolicy3->condition_value = $rowData[2];
                            $professionalPolicy3->parent_condition_id = $professionalPolicy2->id;
                            $professionalPolicy3->parent_condition_value = $professionalPolicy2->condition_value;
                            $professionalPolicy3->save();


                            $professionalPolicy4 = new ProfessionalPolicyDetails();

                            $professionalPolicy4->policy_id = 1;
                            $professionalPolicy4->calculation_field = "cash_profit_program";
                            $professionalPolicy4->linked_condition_key = "loan_amount";
                            $professionalPolicy4->condition = "in_range";
                            $professionalPolicy4->condition_type = "and";
                            $professionalPolicy4->condition_value = $rowData[3];
                            $professionalPolicy4->parent_condition_id = $professionalPolicy3->id;
                            $professionalPolicy4->parent_condition_value = $professionalPolicy3->condition_value;
                            $professionalPolicy4->save();


                            $professionalPolicy5 = new ProfessionalPolicyDetails();

                            $professionalPolicy5->policy_id = 1;
                            $professionalPolicy5->calculation_field = "cash_profit_program";
                            $professionalPolicy5->final_value = $rowData[7];
                            $professionalPolicy5->linked_condition_key = "ownership_status";
                            $professionalPolicy5->condition = "equals_to";
                            $professionalPolicy5->condition_type = "and";
                            $professionalPolicy5->condition_value = $rowData[4];
                            $professionalPolicy5->parent_condition_id = $professionalPolicy4->id;
                            $professionalPolicy5->parent_condition_value = $professionalPolicy4->condition_value;
                            $professionalPolicy5->save();


                            $professionalPolicy11 = new ProfessionalPolicyDetails();

                            $professionalPolicy11->policy_id = 1;
                            $professionalPolicy11->calculation_field = "receipts_program";
                            $professionalPolicy11->linked_condition_key = "profile";
                            $professionalPolicy11->condition = "equals_to";
                            $professionalPolicy11->condition_type = "and";
                            $professionalPolicy11->condition_value = $rowData[0];
                            $professionalPolicy11->save();


                            $professionalPolicy21 = new ProfessionalPolicyDetails();

                            $professionalPolicy21->policy_id = 1;
                            $professionalPolicy21->calculation_field = "receipts_program";
                            $professionalPolicy21->linked_condition_key = "employment_type";
                            $professionalPolicy21->condition = "equals_to";
                            $professionalPolicy21->condition_type = "and";
                            $professionalPolicy21->condition_value = $rowData[1];
                            $professionalPolicy21->parent_condition_id = $professionalPolicy11->id;
                            $professionalPolicy21->parent_condition_value = $professionalPolicy11->condition_value;
                            $professionalPolicy21->save();


                            $professionalPolicy31 = new ProfessionalPolicyDetails();

                            $professionalPolicy31->policy_id = 1;
                            $professionalPolicy31->calculation_field = "receipts_program";
                            $professionalPolicy31->linked_condition_key = "experience";
                            $professionalPolicy31->condition = "greater_than_equals_to";
                            $professionalPolicy31->condition_type = "and";
                            $professionalPolicy31->condition_value = $rowData[2];
                            $professionalPolicy31->parent_condition_id = $professionalPolicy21->id;
                            $professionalPolicy31->parent_condition_value = $professionalPolicy21->condition_value;
                            $professionalPolicy31->save();


                            $professionalPolicy41 = new ProfessionalPolicyDetails();

                            $professionalPolicy41->policy_id = 1;
                            $professionalPolicy41->calculation_field = "receipts_program";
                            $professionalPolicy41->linked_condition_key = "loan_amount";
                            $professionalPolicy41->condition = "in_range";
                            $professionalPolicy41->condition_type = "and";
                            $professionalPolicy41->condition_value = $rowData[3];
                            $professionalPolicy41->parent_condition_id = $professionalPolicy31->id;
                            $professionalPolicy41->parent_condition_value = $professionalPolicy31->condition_value;
                            $professionalPolicy41->save();


                            $professionalPolicy51 = new ProfessionalPolicyDetails();

                            $professionalPolicy51->policy_id = 1;
                            $professionalPolicy51->calculation_field = "receipts_program";
                            $professionalPolicy51->final_value = $rowData[7];
                            $professionalPolicy51->linked_condition_key = "ownership_status";
                            $professionalPolicy51->condition = "equals_to";
                            $professionalPolicy51->condition_type = "and";
                            $professionalPolicy51->condition_value = $rowData[4];
                            $professionalPolicy51->parent_condition_id = $professionalPolicy41->id;
                            $professionalPolicy51->parent_condition_value = $professionalPolicy41->condition_value;
                            $professionalPolicy51->save();
                        }
                    }
                }
            }
        }
    }
}
