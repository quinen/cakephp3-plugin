<?php

namespace Quinen\View\Helper\Traits;

trait TableTrait
{
    public function _injectTableClasses($classes, $options)
    {
        // convert isBordered by table-bordered class
        $tableClasses = collection($classes)->reduce(function ($reducer, $class) use (&$options) {
            $optionName = "is".ucfirst($class);
            if (isset($options[$optionName]) && $options[$optionName]) {
                $reducer[] = "table-".$class;
            }
            unset($options[$optionName]);
            return $reducer;
        }, ['table']);

        // inject class in options
        return $this->injectClasses($tableClasses, $options);
    }
    
    /*
        genere une table = thead(tr+th) + tbody(tr+td) + tfoot
    */
    public function table(array $datas, array $maps = [], array $options = [])
    {
        $options += [
            'isBordered'    => true,
            'isCondensed'   => true,
            //'isXcondensed'  => true,
            'isHover'       => true,
            'isStriped'     => true,
            'title'         => false,
            'icon'          => false,
            'type'          => "default"
        ];

        $options = $this->_injectTableClasses(['bordered','condensed','xcondensed','hover','striped'], $options);

        // si map vide on la complete avec les champs label,field,format
        $maps = $this->_completeMapping($maps, $datas[0]);

        // on genere l'entete
        $entete = $this->tag('tr', implode("\n\t\t", collection($maps)->map(function ($map, $index) {
            list($label,$labelOptions) = $this->_extractContentOptions($map['label']);
            return $this->tag('th', $label, $labelOptions);
        })->toArray()));

        $thead = "\n\t".$this->tag('thead', $entete);

        // on genere les données
        // pour chaque ligne
        $lines = collection($datas)->map(function ($data) use ($maps) {
            // pour chaque colonne
            $columns = collection($maps)->map(function ($map) use ($data) {
//debug($map);
                // label,field,format
                list($value,$valueOptions) = $this->_formatField($data, $map);
                return $this->tag('td', $value, $valueOptions);
            })->toArray();
            return "\n\t".$this->tag('tr', implode("\n\t\t", $columns));
        })->toArray();

        $tbody = "\n\t".$this->tag('tbody', implode("\n", $lines));
        $tfoot = "";
        $table = "\n".$this->tag('table', $thead.$tbody.$tfoot, $options);

        return $this->panel(false, [
            'content'   => $table,
            'title'     => $options['title'],
            'type'      => $options['type']
        ]);
    }
}
