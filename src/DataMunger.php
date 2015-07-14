<?php

class DataMunger {

    public $data = null;

    /**
     * [prefixList prefix all values in a array]
     * @param  [array] $array   [the array (by reference) to operate on.]
     * @param  [string] $prefix [the prefix string.]
     * @return [array]        [the original array.]
     */
    public function prefixList($array, $prefix) {
        $ret = [];
        foreach ($array as $key => $value) {
            $ret[$key] = $prefix . $value;
        }
        $this->data = $ret;
        return $this;
    }

    /**
     * [suffixList suffix all values in a array]
     * @param  [array] $array   [the array (by reference) to operate on.]
     * @param  [string] $suffix [the suffix string.]
     * @return [array]        [the original array.]
     */
    public function suffixList($array, $suffix) {
        $ret = [];
        foreach ($array as $key => $value) {
            $ret[$key] = $value . $suffix;
        }
        $this->data = $ret;
        return $this;
    }

    /**
     * [prefixSuffixList prefix and suffix all values in a array]
     * @param  [array] $array   [the array (by reference) to operate on.]
     * @param  [string] $prefix [the prefix string.]
     * @param  [string] $suffix [the suffix string.]
     * @return [array]        [the original array.]
     */
    public function prefixSuffixList($array, $prefix, $suffix) {
        $ret = [];
        foreach ($array as $key => $value) {
            $ret[$key] = $prefix . $value . $suffix;
        }
        $this->data = $ret;
        return $this;
    }

    /**
     * [getFirstOfObject A quick way to get the first item of an object]
     * @param  [obj] $obj
     * @return [array]
     */
    public function getFirstOfObject($obj) {
        $cnt = 0;
        foreach ($obj as $key => $value) {
            if($cnt == 0) {
                $this->data = $obj[$key];
                break;
            }
        }
        return $this;
    }

    /**
     * [arrayValFilter Easier array filter, using an array of matching vals]
     * @param  [array] $accepted [array of acceptable values.]
     * @param  [array] $arr [the array to filter against.]
     * @return [array] [the new, filtered array.]
     */
    public function arrayValFilter($accepted, $arr) {
        $filtered = [];
        foreach ($arr as $key => $value) {
            if(in_array($value, $accepted)) {
                $filtered[$key] = $value;
            }
        }
        $this->data = $filtered;
        return $this;
    }

    /**
     * [arrayValPrune Opposite of arrayValFilter, using an array of negating keys]
     * @param  [array] $to_prune [array of keys to prune.]
     * @param  [array] $arr [the array to prune.]
     * @return [array] [the new, pruned array.]
     */
    public function arrayValPrune($to_prune, $arr) {
        $pruned = [];
        foreach ($arr as $key => $value) {
            if(!in_array($value, $to_prune)) {
                $pruned[$key] = $value;
            }
        }
        $this->data = $pruned;
        return $this;
    }

    /**
     * [arrayKeyFilter Easier array filter, using an array of matching keys]
     * @param  [array] $accepted [array of acceptable keys.]
     * @param  [array] $arr [the array to filter against.]
     * @return [array] [the new, filtered array.]
     */
    public function arrayKeyFilter($accepted, $arr) {
        $filtered = [];
        foreach ($arr as $key => $value) {
            if(in_array($key, $accepted)) {
                $filtered[$key] = $value;
            }
        }
        $this->data = $filtered;
        return $this;
    }

    /**
     * [arrayKeyPrune Opposite of arrayKeyFilter, using an array of negating keys]
     * @param  [array] $to_prune [array of keys to prune.]
     * @param  [array] $arr [the array to prune.]
     * @return [array] [the new, pruned array.]
     */
    public function arrayKeyPrune($to_prune, $arr) {
        $pruned = [];
        foreach ($arr as $key => $value) {
            if(!in_array($key, $to_prune)) {
                $pruned[$key] = $value;
            }
        }
        $this->data = $pruned;
        return $this;
    }

    /**
     * [extractObjValsByKey Given an array of objects, extract the
     * values in each, specified by `key`]
     * @param  [type] $key [the key to use for reference]
     * @param  [array] $arr [the multi-dimensional array to reference.]
     * @return [array] [an array of the values obtained by `key`]
     */
    public function extractObjValsByKey($key, $arr) {
        $vals = [];
        foreach ($arr as $_arr) {
            if(isset($_arr->{$key})) {
                array_push($vals, $_arr->{$key});
            }
        }
        $this->data = $vals;
        return $this;
    }

    /**
     * [getKeys A facade over the business of getting keys for
     * an array vs. object]
     * @param  [array or object] $instance [the array/object,]
     * @return [array]           [keys, or empty array.]
     */
    public function getKeys($instance) {
        $_type = gettype($instance);
        if($_type == 'object') {
            $this->data = get_object_vars($instance);
        } else if($_type == 'array') {
            $this->data = array_keys($instance);
        } else {
            $this->data = [];
        }
        return $this;
    }

    /**
     * [keyByVal Convert a nested "array" indexed by one value to an "array"
     * indexed by a matching `key`'s value' found within each array]
     * @param  [object] $arr
     * @param  [string/integer] $key [the key to use for keying - must exist within each child array]
     * @return [object] [the re-keyed object]
     */
    public function keyByVal($key, $arr) {
        $data = [];
        foreach ($arr as $_key => $sub_arr) {
            foreach ($sub_arr as $_ => $value) {
                $res = $sub_arr[$key];
                $data[$res] = $sub_arr;
            }
        }
        $this->data = $data;
        return $this;
    }

    /**
     * [transformVals given a transform table, map the original values to new values.]
     * @param  [array] $transform_table [an array representing old -> new values]
     * @param  [array] $arr             [the array to operate on.]
     * @return [array]                  [the transformed array.]
     */
    public function transformVals($transform_table, $arr) {
        $xformed = [];
        foreach ($arr as $key => $val) {
            if(isset($transform_table[$val])) {
                $xformed[$key] = $transform_table[$val];
            } else {
                $xformed[$key] = $val;
            }
        }
        $this->data = $xformed;
        return $this;
    }

    /**
     * [transformKeys given a transform table, map the original keys to new keys.]
     * @param  [array] $transform_table [an array representing old -> new keys]
     * @param  [array] $arr             [the array to operate on.]
     * @return [array]                  [the transformed array.]
     */
    public function transformKeys($transform_table, $arr) {
        $xformed = [];
        foreach ($arr as $key => $val) {
            if(isset($transform_table[$key])) {
                $xformed[$transform_table[$key]] = $val;
            } else {
                $xformed[$key] = $val;
            }
        }
        $this->data = $xformed;
        return $this;
    }

    public function getData() {
        return $this->data;
    }
}
