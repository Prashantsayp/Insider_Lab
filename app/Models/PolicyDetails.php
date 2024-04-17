<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use phpDocumentor\Reflection\Types\Self_;

/**
 * Class PolicyDetails
 * @package App\Models
 * @version October 7, 2020, 3:04 pm UTC
 *
 * @property integer $policy_id
 * @property string $linked_condition_key
 * @property string $condition
 * @property integer $condition_value
 * @property string $condition_type
 * @property integer $parent_condition_id
 * @property string $parent_condition_value
 */
class PolicyDetails extends Model
{
    use SoftDeletes;

    public $table = 'policy_details';

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
        "calculation_field",
        "final_value"
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
        'parent_condition_value' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'policy_id' => 'required',
        'linked_condition_key' => 'required',
        'condition' => 'required',
        'condition_value' => 'required',
        'condition_type' => 'required'
    ];


    public function parent()
    {
        return $this->belongsTo(\App\Models\PolicyDetails::class, 'parent_condition_id');
    }

    public function childrens()
    {
        return $this->hasMany(\App\Models\PolicyDetails::class, 'parent_condition_id');
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
        $childs = $parent->childrens()->get();
        if ($parent->condition == "equals_to") {
            if ($input[$parent->linked_condition_key] == $parent->condition_value) {
                if (isset($childs) && isset($childs->first()->id)) {
                    foreach ($childs as $childKey => $child) {
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
            if (($input[$parent->linked_condition_key] > $min) && ($input[$parent->linked_condition_key] < $max) ) {
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
            if ($input[$parent->linked_condition_key] >= $parent->final_value) {
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
