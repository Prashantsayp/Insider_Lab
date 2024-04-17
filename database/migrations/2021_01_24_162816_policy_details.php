<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PolicyDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('professional_policy_details')) {
            DB::select(DB::raw("CREATE TABLE `professional_policy_details` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `policy_id` int(11) NOT NULL, `linked_condition_key` varchar(200) NOT NULL, `condition` varchar(100) NOT NULL COMMENT 'Accepted values : equals_to, greater_than, greater_than_equals_to, less_than, less_than_equals_to, exact_equal_to', `condition_value` varchar(250) NOT NULL, `condition_type` enum('and','or') NOT NULL, `parent_condition_id` int(11) DEFAULT NULL, `parent_condition_value` varchar(100) DEFAULT NULL, `deleted_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP, `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, `calculation_field` varchar(100) DEFAULT NULL, `final_value` varchar(50) DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8"));
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('professional_policy_details')) {
            Schema::dropIfExists('professional_policy_details');
        }
    }
}
