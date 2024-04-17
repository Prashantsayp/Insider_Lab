<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProfessionalPolicyDetails
 * @package App\Models
 * @version January 24, 2021, 4:41 pm UTC
 *
 * @property integer $policy_id
 * @property string $linked_condition_key
 * @property string $condition
 * @property string $condition_value
 * @property string $condition_type
 * @property integer $parent_condition_id
 * @property string $parent_condition_value
 * @property string $calculation_field
 * @property string $final_value
 */
class ProfessionalPolicyDetails extends Model
{
    use SoftDeletes;

    public $table = 'professional_policy_details';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'policy_id',
        'linked_condition_key',
        'condition',
        'condition_value',
        'condition_type',
        'parent_condition_id',
        'parent_condition_value',
        'calculation_field',
        'final_value'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'policy_id' => 'integer',
        'linked_condition_key' => 'string',
        'condition' => 'string',
        'condition_value' => 'string',
        'condition_type' => 'string',
        'parent_condition_id' => 'integer',
        'parent_condition_value' => 'string',
        'calculation_field' => 'string',
        'final_value' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'policy_id' => 'required|integer',
        'linked_condition_key' => 'required|string|max:200',
        'condition' => 'required|string|max:100',
        'condition_value' => 'required|string|max:250',
        'condition_type' => 'required|string',
        'parent_condition_id' => 'nullable|integer',
        'parent_condition_value' => 'nullable|string|max:100',
        'calculation_field' => 'nullable|string|max:100',
        'final_value' => 'nullable|string|max:50'
    ];



    public function parent()
    {
        return $this->belongsTo(\App\Models\ProfessionalPolicyDetails::class, 'parent_condition_id');
    }

    public function childrens()
    {
        return $this->hasMany(\App\Models\ProfessionalPolicyDetails::class, 'parent_condition_id');
    }


    // public function getArrayDetails($policyId = 1, $input = [])
    // {
    //     $array = [];
    //     $parentDetails = $this->getAllParentConditions($policyId);
    //     foreach ($parentDetails as $parentKey => $parent) {
    //         $array = array_merge($array, $this->calculateFinalParent($parent, $input));
    //     }
    //     return $array;
    // }

    public function getAllParentConditions($policyId)
    {
        return self::with("childrens")->where([["policy_id", "=", $policyId]])->whereNull('parent_condition_id')->get();
    }



    public function calculateFinalParent($parent, $input)
    {
        $returnArray = [];

        $finalArray = [];
        // Retrieve posts with at least ten comments containing words like foo%...
        /* $posts = App\Models\Post::whereHas('comments', function (Builder $query) {
            $query->where('content', 'like', 'foo%');
        }, '>=', 10)->get(); */
        // return $parent->childrens;
        // echo json_encode($parent);
        $childs = $parent->childrens()->get();
        // echo json_encode($childs) . "<br /><br />";
        if ($parent->condition == "equals_to") {
            if ($input[$parent->linked_condition_key] == $parent->condition_value) {
                if (isset($childs) && isset($childs->first()->id)) {
                    foreach ($childs as $childKey => $child) {
                        Log::info('Child' ,[$child] );
                        $temp = [];
                        $childs2 = $child->childrens()->get();
                        if (isset($childs2) && isset($childs2->first()->id)) {
                            // $temp[$child->calculation_field][$child->linked_condition_key] = $child->toArray();
                            $val = $this->calculateFinalParent($child, $input);
                            if ($val) {
                                return $this->calculateFinalParent($child, $input);
                                break;
                            }
                        } else {
                            $val = $this->calculateFinalParent($child, $input);
                            if ($val) {
                                return $this->calculateFinalParent($child, $input);
                                break;
                            }
                        }
                        $finalArray[] = $temp;
                    }
                } else {
                    return $parent->final_value;
                }
            }
        }
        if ($parent->condition == "in_range") {
            list($min, $max) = explode(",", $parent->condition_value);
            if (($input[$parent->linked_condition_key] > $min) && ($input[$parent->linked_condition_key] < $max)) {
                if (isset($childs) && isset($childs->first()->id)) {
                    foreach ($childs as $childKey => $child) {
                        $temp = [];
                        $childs2 = $child->childrens()->get();
                        if (isset($childs2) && isset($childs2->first()->id)) {
                            $temp[$child->calculation_field][$child->linked_condition_key] = $child->toArray();
                            $val = $this->calculateFinalParent($child, $input);
                            if ($val) {
                                return $this->calculateFinalParent($child, $input);
                                break;
                            }
                        } else {
                            $val = $this->calculateFinalParent($child, $input);
                            if ($val) {
                                return $this->calculateFinalParent($child, $input);
                                break;
                            }
                        }
                        $finalArray[] = $temp;
                    }
                } else {
                    return $parent->final_value;
                }
            } else {
                return false;
            }
        }
        if ($parent->condition == "greater_than_equals_to") {
            if (((int)$input[$parent->linked_condition_key]) >= ((int)$parent->final_value)) {
                if (isset($childs) && isset($childs->first()->id)) {
                    foreach ($childs as $childKey => $child) {
                        $temp = [];
                        $childs2 = $child->childrens()->get();
                        if (isset($childs2) && isset($childs2->first()->id)) {
                            $temp[$child->calculation_field][$child->linked_condition_key] = $child->toArray();
                            $val = $this->calculateFinalParent($child, $input);
                            if ($val) {
                                return $this->calculateFinalParent($child, $input);
                                break;
                            }
                        } else {
                            $val = $this->calculateFinalParent($child, $input);
                            if ($val) {
                                return $this->calculateFinalParent($child, $input);
                                break;
                            }
                        }
                        $finalArray[] = $temp;
                    }
                } else {
                    return $parent->final_value;
                }
            } else {
                return false;
            }
        }
    }
}
