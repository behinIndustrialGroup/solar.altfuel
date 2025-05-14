<?php

namespace MyFormBuilder\Fields;

class HelpField extends AbstractField
{
    public function render(): string
    {
        $s = '<div class="" ';
        foreach($this->attributes as $key => $value){
            
            if($key == 'required'){
                if($value == 'on'){
                    $s .= 'required ';
                }
            }
            if($key == 'readonly'){
                if($value == 'on'){
                    $s .= 'readonly ';
                }
            }
            if($key == 'style'){
                $s .= 'style="' . $value . '" ';
            }
            if($key == 'id'){
                $s .= 'id="' . $value . '" ';
            }
        }
        $s .= '>';
        $s .= trans($this->name);
        $s .= '<p>';
        $s .= $this->attributes['options'] ?? '';
        $s .= '</p>';
        if(isset($this->attributes['script'])){
            $s .= '<script>';
            $s .= $this->attributes['script'];
            $s .= '</script>';
        }

        $s .= '</div>';
        return $s;
        if (!isset($this->attributes['type'])) {
            $this->attributes['type'] = 'text';
        }
        return sprintf('<input %s>', $this->buildAttributes());
    }
}
