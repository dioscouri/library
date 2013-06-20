<?php
/**
 * @version	1.5
 * @package	DSC
 * @author 	Dioscouri Design
 * @link 	http://www.dioscouri.com
 * @copyright Copyright (C) 2007 Dioscouri Design. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 */

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
 
/**
 * Provide easy filtering iterator for arrays
 * @see: http://php.net/manual/en/class.filteriterator.php
 */
class DSCArrayFilter extends FilterIterator 
{
    private $filters = array();
    private $data = array();

    public function __construct( $data, $filter_field = NULL, $filter_method = NULL, $filter_value = NULL ) {
        $this->data = $data;
        $iterator = $this->get_iterator();
        parent::__construct( $iterator );

        if ( ! is_null( $filter_field ) && ! is_null( $filter_method ) && ! is_null( $filter_value ) )
            $this->add_filter( $filter_field, $filter_method, $filter_value );
    }

    public function get_iterator() {
        if ( is_object( $this->data ) && method_exists( $this->data, 'getIterator' ) )
            return $this->data->getIterator();
        if ( is_array( $this->data ) ) {
            $object = new ArrayObject( $this->data );
            return $object->getIterator();
        }
        return $this->data;
    }

    public function accept() {
        $data = $this->getInnerIterator()->current();

        return $this->dispatch_filter( $data );
    }

    /**
     * 
     * @param unknown_type $filter_field
     * @param unknown_type $filter_method
     * @param unknown_type $filter_value
     * @param unknown_type $filter_type
     * @return DSCArrayFilter
     */
    public function add_filter( $filter_field, $filter_method, $filter_value ) {
        $this->filters[] = array( 'filter_field' => $filter_field, 'filter_method' => $filter_method, 'filter_value' => $filter_value );
        return $this;
    }

    private function dispatch_filter( $data ) {
        $result = true; // by default don't filter
        foreach( $this->filters as $filter ) {
            extract( $filter );
            
            if (strpos($filter_method, 'any_') === 0 && is_array($filter_field)) 
            {
                if ( is_callable( array( &$this, $filter_method ) ) )
                    $result = call_user_func( array( &$this, $filter_method ), $filter_field, $filter_value );
                else if ( function_exists( $filter_method ) ) {
                    $result = call_user_func( $filter_method, $filter_field, $filter_value );
                }
                
                if ( false == $result ) {
                    return false;
                }
                                
            } 
                else 
            {
                $cmp_value = null;
                
                if ( is_object( $data ) ) {
                    if ( isset( $data->{$filter_field} ) || is_null( $data->{$filter_field} ) ) {
                        $cmp_value = $data->{$filter_field};
                    }
                } else if ( is_array( $data ) ) {
                    if ( isset( $data[$filter_field] ) || is_null( $data[$filter_field] ) ) {
                        $cmp_value = $data[$filter_field];
                    }
                }
                 
                if ( is_callable( array( &$this, $filter_method ) ) )
                    $result = call_user_func( array( &$this, $filter_method ), $cmp_value, $filter_value );
                else if ( function_exists( $filter_method ) ) {
                    $result = call_user_func( $filter_method, $cmp_value, $filter_value );
                }
                
                if ( false == $result ) {
                    return false;        
                }        
            }
        }
        
        return true;
    }

    private function gt( $cmp_value, $filter_value ) {
        if ( is_numeric( $cmp_value ) )
            return (int) $cmp_value > (int) $filter_value;
        else
            return strcmp( $cmp_value, $filter_value ) > 0;
    }

    private function lt( $cmp_value, $filter_value ) {
        if ( is_numeric( $cmp_value ) )
            return (int) $cmp_value < (int) $filter_value;
        else
            return strcmp( $cmp_value, $filter_value ) < 0;

    }

    private function eq( $cmp_value, $filter_value ) {
        if ( is_numeric( $cmp_value ) || is_numeric($filter_value) ) {
            return (int) $cmp_value == (int) $filter_value;
        }
        else {
            return strcmp( $cmp_value, $filter_value ) == 0;
        }
    }

    private function exists( $cmp_value, $filter_value ) {
        return (!empty($cmp_value) && !is_null($cmp_value));
    }
    
    private function isnull( $cmp_value, $filter_value ) {
        return (empty($cmp_value) || is_null($cmp_value));
    }
    
    private function in( $cmp_value, $filter_value ) {
        $filter_value = (array) $filter_value;
        return in_array( $cmp_value, $filter_value );
    }
    
    private function between( $cmp_value, $filter_value ) {
        $filter_value = (array) $filter_value;
        return ( $cmp_value > $filter_value[0] && $cmp_value < $filter_value[1] );
    }
    
    private function regex( $cmp_value, $filter_value ) {
        return preg_match( $filter_value, $cmp_value );
    }
    
    private function contains( $cmp_value, $filter_value ) {
        return ( preg_match('/' . $filter_value . '/i', $cmp_value ) );        
    }
    
    private function any_contains( $fields, $filter_value ) {
        $data = $this->getInnerIterator()->current();
        
        $found = false;
        $fields = (array) $fields;
        
        foreach ($fields as $filter_field) 
        {
            if ( is_object( $data ) ) {
                if ( isset( $data->{$filter_field} ) ) {
                    $cmp_value = $data->{$filter_field};
                }
            } else if ( is_array( $data ) ) {
                if ( isset( $data[$filter_field] ) ) {
                    $cmp_value = $data[$filter_field];
                }
            }
             
            if ( empty( $cmp_value ) ) {
                continue;
            }
            
            $found = preg_match('/' . $filter_value . '/i', $cmp_value );
            
            if ($found) {
                break;
            }
        }
        
        return $found;
    }

    private function older_than( $cmp_value, $filter_value ) {
        if ( !is_numeric( $cmp_value ) )
            $cmp_value = strtotime( $cmp_value );
        if ( !is_numeric( $filter_value ) )
            $filter_value = strtotime( $filter_value );
        else
            $filter_value = $filter_value;

        return $cmp_value < $filter_value;
    }

    private function newer_than( $cmp_value, $filter_value ) {
        if ( !is_numeric( $cmp_value ) )
            $cmp_value = strtotime( $cmp_value );
        if ( !is_numeric( $filter_value ) )
            $filter_value = strtotime( $filter_value );
        else
            $filter_value = $filter_value;

        return $cmp_value > $filter_value;

    }
}

if ( !function_exists( 'dsc_array_filter' ) ) {
    function dsc_array_filter( $data, $filter_field = NULL, $filter_method = NULL, $filter_value = NULL ) {
        $dsc_array_filter = new DSCArrayFilter( $data, $filter_field, $filter_method, $filter_value );
        return $dsc_array_filter;
    }
}

?>