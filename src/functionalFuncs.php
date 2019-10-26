<?php

namespace EasyCallback\internal;

function mapIterator($collection, callable $valueCallback = null, callable $keyCallback = null) {
    foreach($collection as $key => $value) {
        $newValue = $valueCallback ? $valueCallback($value, $key, $collection) : $value;
        $newKey   = $keyCallback   ? $keyCallback($value, $key, $collection) : $key;
        yield $newKey => $newValue;
    }
}

function filterIterator($collection, callable $callback, $preserveKeys = false) {
    foreach($collection as $key => $value) {
        if ($callback($value, $key, $collection)) {
            if ($preserveKeys) {
                yield $key => $value;
            } else {
                yield $value;
            }
        }
    }
}

function first($collection, callable $callback, $default = null) {
    foreach($collection as $key => $value) {
        if ($callback($value, $key, $collection)) {
            return $value;
        }
    }

    return $default;
}

function last($collection, callable $callback, $default = null) {
    $return = $default;

    foreach($collection as $key => $value) {
        if ($callback($value, $key, $collection)) {
            $return = $value;
        }
    }

    return $return;
}

function firstKey($collection, callable $callback) {
    foreach($collection as $key => $value) {
        if ($callback($value, $key, $collection)) {
            return $key;
        }
    }

    return null;
}

function lastKey($collection, callable $callback) {
    $return = null;

    foreach($collection as $key => $value) {
        if ($callback($value, $key, $collection)) {
            $return = $key;
        }
    }

    return $return;
}

function _maximum($collection, callable $callback, $revert, $returnKey) {
    $isFirst = true;
    $lastCmpValue = null;
    $return = null;

    foreach($collection as $key => $value) {
        $cmpValue = $callback($value, $key, $collection);
        if ($isFirst || ($revert ? $cmpValue < $lastCmpValue : $cmpValue > $lastCmpValue)) {
            $isFirst      = false;
            $lastCmpValue = $cmpValue;
            $return       = $returnKey ? $key : $value;
        }
    }

    return $return;
}

function maximum($collection, callable $callback) {
    return _maximum($collection, $callback, false, false);
}

function minimum($collection, callable $callback) {
    return _maximum($collection, $callback, true, false);
}

function maximumKey($collection, callable $callback) {
    return _maximum($collection, $callback, false, true);
}

function minimumKey($collection, callable $callback) {
    return _maximum($collection, $callback, true, true);
}

function groupBy($collection, callable $callback) {
    $return = [];

    foreach($collection as $key => $value) {
        $return[$callback($value, $key, $collection)][] = $value;
    }

    return $return;
}

function some($collection, callable $callback) {
    foreach($collection as $key => $value) {
        if ($callback($value, $key, $collection)) {
            return true;
        }
    }

    return false;
}

function every($collection, callable $callback) {
    foreach($collection as $key => $value) {
        if (!$callback($value, $key, $collection)) {
            return false;
        }
    }

    return true;
}

function none($collection, callable $callback) {
    foreach($collection as $key => $value) {
        if ($callback($value, $key, $collection)) {
            return false;
        }
    }

    return true;
}

function id($item) {
    if ($item === null) {
        return null;
    } elseif (is_object($item)) {
        return spl_object_hash($item);
    } else {
        return (string) $item;
    }
}

function duplicates($collection, callable $callback = null, $ignoreNulls = false) {
    $keys = [];
    foreach($collection as $key => $value) {
        $keyVal = id($callback ? $callback($value, $key, $collection) : $value);
        if ($ignoreNulls && $keyVal === null) {
            continue;
        }

        if (isset($keys[$keyVal])) {
            return true;
        }

        $keys[$keyVal] = true;
    }

    return false;
}

function uniqueIterator($collection, callable $callback = null, $ignoreNulls = false, $preserveKeys = false) {
    $keys = [];
    foreach($collection as $key => $value) {
        $keyVal = id($callback ? $callback($value, $key, $collection) : $value);
        if (($ignoreNulls && $keyVal === null) || empty($keys[$keyVal])) {
            if ($preserveKeys) {
                yield $key => $value;
            } else {
                yield $value;
            }
            $keys[$keyVal] = true;
        }
    }
}

function flatMapIterator($collection, callable $callback) {
    $keys = [];
    foreach($collection as $key => $value) {
        foreach($callback($value, $key, $collection) as $item) {
            $id = id($item);
            if (empty($keys[$id])) {
                $keys[$id] = true;
                yield $item;
            }
        }
    }
}

function flattenIterator($collection) {
    foreach($collection as $subCollection) {
        foreach($subCollection as $item) {
            yield $item;
        }
    }
}

function mergeIterator($collection, callable $callback = null) {
    $keys = [];
    foreach($collection as $key => $subCollection) {
        foreach($subCollection as $subKey => $item) {
            $currentKey = $callback ? $callback($item, $subKey, $key) : $subKey;
            if (empty($keys[$currentKey])) {
                yield $currentKey => $item;
                $keys[$currentKey] = true;
            }
        }
    }
}

function mergeAllIterator($collection, callable $callback = null) {
    foreach($collection as $key => $subCollection) {
        foreach($subCollection as $subKey => $item) {
            $currentKey = $callback ? $callback($item, $subKey, $key) : $subKey;
            yield $currentKey => $item;
        }
    }
}

function joinByValue($collection1, $collection2, callable $callback = null) {
    $callback         = $callback ?: function($value1, $value2) {return [$value1, $value2];};
    $collection2ByKey = iterator_to_array(mapIterator($collection2, null, 'EasyCallback\internal\id'));
    $result           = [];
    $usedKeys         = [];
    foreach($collection1 as $value1) {
        $id = id($value1);
        if ($id !== null && isset($collection2ByKey[$id])) {
            $result[]      = $callback($value1, $collection2ByKey[$id]);
            $usedKeys[$id] = true;
        } else {
            $result[] = $callback($value1, null);
        }
    }

    foreach($collection2 as $value2) {
        $id = id($value2);
        if ($id === null || empty($usedKeys[$id])) {
            $result[] = $callback(null, $value2);
        }
    }

    return $result;
}

function join($collection1, $collection2, callable $callback = null) {
    $callback    = $callback ?: function($value1, $value2) {return [$value1, $value2];};
    $collection2 = $collection2 instanceof \Traversable ? iterator_to_array($collection2) : $collection2;
    $result      = [];

    foreach($collection1 as $key => $value1) {
        if ($collection2[$key]) {
            $result[$key] = $callback($value1, $collection2[$key], $key);
            unset($collection2[$key]);
        } else {
            $result[$key] = $callback($value1, null, $key);
        }
    }

    foreach($collection2 as $key => $value2) {
        $result[$key] = $callback(null, $value2, $key);
    }

    return $result;
}

function chunkIterator($collection, $size, callable $sizeCallback = null) {
    $chunk     = [];
    $chunkSize = 0;
    foreach($collection as $key => $value) {
        $currentSize = $sizeCallback ? $sizeCallback($value, $key, $collection) : 1;
        $chunkSize   += $currentSize;
        if ($chunkSize > $size && $chunk) {
            yield $chunk;
            $chunk     = [];
            $chunkSize = $currentSize;
        }

        $chunk[] = $value;
    }

    if ($chunk) {
        yield $chunk;
    }
}

function reduce($collection, callable $callback, $initValue = null) {
    $firstPass = true;
    $lastVal = $initValue;

    foreach($collection as $value) {
        if ($firstPass && $initValue === null) {
            $lastVal = $value;
        } else {
            $lastVal = $callback($lastVal, $value);
        }
        $firstPass = false;
    }

    return $lastVal;
}

function recursiveIterator($item, callable $callback, $mode = 0)
{
    if ($mode & \RecursiveIteratorIterator::SELF_FIRST) {
        yield $item;
        $subItem = true; //without setting this second yield may yield this item second time
    }

    foreach($callback($item) as $subItem) {
        foreach (recursiveIterator($subItem, $callback, $mode) as $subSubItem) {
            yield $subSubItem;
        }
    }

    if ($mode & \RecursiveIteratorIterator::CHILD_FIRST || !isset($subItem)) {
        yield $item;
    }
}

function valuesIterator($collection) {
    foreach($collection as $value) {
        yield $value;
    }
}