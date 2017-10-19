<?php

namespace Quinen\View\Helper;

use Cake\Utility\Hash;

trait HtmlTrait
{


    // format a $value
    // format can be a string, an array or a an array/array
    // example
    // "strtoupper" => function strtoupper
    // "::ul"
    // ["strtolower","ucfirst"] => apply 2 format 
    protected function _formatValue($value, $format = false)
    {
        if ($format) {
            $value = call_user_func($format, $value);
        }
        return $value;
    }

    protected function _formatField($data, $map)
    {
        // field
        list($field,$valueOptions) = $this->_extractContentOptions($map['field']);

        // get value
        $value = Hash::get($data, $field);
          
          // format value
        if ($map['format']) {
            $formattedValue = $this->_formatValue($value, $map['format']);
        } else {
            $formattedValue = $value;
        }

        if (is_array($formattedValue)) {
            $formattedValue = json_encode($formattedValue);
        }
          // formatage de la valeur
          // linkification

          return [$formattedValue,$valueOptions];
    }
    // transforme les données de type :
    //     "toto"              => "toto"   ,[]
    //     ["titi"]            => "titi"   ,[]
    //     ["tata",['a'=>"b"]] => "tata"   ,['a'=>"b"]
    //     [,['b'=>"c"]]       => null     ,['b'=> "c"]
    protected function _extractContentOptions($content, $contentDefault = null)
    {
        $contentOptions = [];
        if (is_array($content)) {
            $contentOptions = Hash::get($content, '1', []);
            $content        = Hash::get($content, '0', $contentDefault);
        }
        return [$content,$contentOptions];
    }

    protected function _completeMapping(array $maps = [], array $data = [])
    {
        // generation d'une map par defaut
        if (empty($maps)) {
            // en cas de structure
            $data = Hash::flatten($data);
            // on recupere chaque cle de data, on en fait le label + field
            $maps = collection($data)->map(function ($d, $t) {
                return [
                    'label'     => $t,
                    'field'     => $t,
                    'format'    => (is_array($d)?[$this,"ul"]:false)
                ];
            })->toArray();
        }
        // on s'assure que les champs obligatoires sont bien present
        $maps = collection($maps)->map(function ($map, $index) {
            if (is_string($map)) {
                $map = [
                    'label'     => $map,
                    'field'     => $map,
                ];
            }
            return $map += [
                'label'     => $index,
                'field'     => $index,
                'format'    => false
            ];
        })->toArray();

        return $maps;
    }

    public function pre($content)
    {
        $html = "";
        if (is_array($content)) {
            $html = var_export($content, true);
        } else {
            $html = $content;
        }
        return $this->tag('pre', $html);
    }

    public function ul($lis, array $options = [])
    {
        if (is_null($lis)) {
            return $lis;
        }

        $html = implode("", collection($lis)->map(function ($liOne) {
            list($li,$liOptions) = $this->_extractContentOptions($liOne);
            return $this->tag('li', $li, $liOptions);
        })->toArray());

        return $this->tag('ul', $html, $options);
    }

}
