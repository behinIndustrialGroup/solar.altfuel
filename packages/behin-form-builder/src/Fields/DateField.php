<?php

namespace MyFormBuilder\Fields;

class DateField extends AbstractField
{
    public function render(): string
    {
        $s = '<div class="form-group">';
        $s .= '<label>';
        $s .= trans('fields.' . $this->name);
        if($this->attributes['required'] == 'on' && $this->attributes['readonly'] != 'on'){
            $s .= ' <span class="text-danger">*</span>';
        }
        $s .= '</label>';
        $s .= '<input type="text" name="' . $this->name . '" ';

        foreach($this->attributes as $key => $value){
            if($key == 'required'){
                if($value == 'on'){
                    $s .= 'required ';
                }
            }
            elseif($key == 'readonly'){
                if($value == 'on'){
                    $s .= 'readonly ';
                }
            }else{
                $s .= $key . '="' . $value . '" ';
            }
        }
        $s .= '>';
        $s .= "<input type='hidden' name='". $this->name ."_alt' id='". $this->name ."_alt'>";
        $s .= "<script>$(function() {
            const picker = $('#$this->name').persianDatepicker({
                viewMode: 'day',
                initialValue: false,
                format: 'YYYY-MM-DD',
                initialValueType: 'persian',
                altField: '#". $this->name ."_alt',
                altFormat: 'YYYY-MM-DD',
                calendar: {
                    persian: {
                        leapYearMode: 'astronomical',
                        locale: 'fa'
                    }
                },
                onSelect: function(unix) {
                    const pd = new persianDate(unix);
                    const gregorian = pd.toCalendar('gregorian');
                    $('#". $this->name ."_alt').val(gregorian.format('YYYY-MM-DD'));
                }
            });
            const \$form = $('#$this->name').closest('form');
            \$form.on('submit', function() {
                const altVal = $('#". $this->name ."_alt').val();
                if (altVal) {
                    $('input[name=\"$this->name\"]').val(altVal);
                }
            });
        });</script>";
        $s .= '</div>';
        return $s;
    }
}
