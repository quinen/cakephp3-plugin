<?php
namespace Quinen\View\Helper;

use BootstrapUI\View\Helper\HtmlHelper as UseHelper;
use Cake\Utility\Hash;

class HtmlHelper extends UseHelper
{
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

    /*
        transforme les données de type :
            "toto"              => "toto"   ,[]
            ["titi"]            => "titi"   ,[]
            ["tata",['a'=>"b"]] => "tata"   ,['a'=>"b"]
            [,['b'=>"c"]]       => null     ,['b'=> "c"]    
    */
    protected function _extractContentOptions($content, $contentDefault = null)
    {
        $contentOptions = [];
        if (is_array($content)) {
            $contentOptions = Hash::get($content, '1', []);
            $content        = Hash::get($content, '0', $contentDefault);
        }
        return [$content,$contentOptions];
    }

    /*
        format a $value
        format can be a string, an array or a an array/array
        example
        "strtoupper" => function strtoupper
        "::ul"
        ["strtolower","ucfirst"] => apply 2 format 
    */
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

    public function button($type = "default", $options = [])
    {
        $classes = ['btn', 'btn-' . $type];

        return $this->tag('button', $type, $this->injectClasses($classes, $options));
    }

    /*
        definition list
        <dl>
            <dd></dd>
            <dt></dt>
        </dl>
        cle = valeur
        question = reponse
        []
    */
    public function dl($data, $maps = [], array $options = [])
    {
        $options += [
            'isHorizontal'  => false
        ];

        if ($options['isHorizontal']) {
            $options = $this->injectClasses("dl-horizontal", $options);
        }
        unset($options['isHorizontal']);

        // si map vide on la complete avec les champs label,field,format
        $maps = $this->_completeMapping($maps, $data);

        // pour chaque ligne
        $html = implode("\n", collection($maps)->map(function ($map, $k) use ($data) {
            // label
            list($label,$labelOptions) = $this->_extractContentOptions($map['label']);
            unset($map['label']);

            list($value,$valueOptions) = $this->_formatField($data, $map);
            unset($map['field']);
            unset($map['format']);

            // field contient le champ
            return $this->tag('dt', $label, $labelOptions).$this->tag('dd', $value, $valueOptions);
        })->toArray());

        return $this->tag('dl', $html, $options);
    }
    /*
        dropdown implementable dans des menus et boutons
    */
    public function dropdown($dropdown, array $options = [])
    {
        $options += [
            'tag'           => "div",
            'tagContent'    => ["button",['class'=>["btn","btn-default"]]],
        ];

        list($tagContent,$tagContentOptions) = $this->_extractContentOptions($options['tagContent']);

        $tagContentOptions += [
            'data-toggle'   => "dropdown"
        ];

        // injectClasses
        $tagContentOptions = $this->injectClasses("dropdown-toggle", $tagContentOptions);

        $button = $this->tag(
            $tagContent,
            $dropdown['content']."&nbsp;".$this->tag('span', "", ['class'=>'caret']),
            $tagContentOptions
        );

        $menu = collection($dropdown['menu'])->map(function ($menu) {
            // gestion separateur
            if ($menu == "/") {
                return ["&nbsp;",['role'=>"separator",'class'=>"divider"]];
            }

            // gestion si texte simple
            if (is_string($menu)) {
                $menu = ['content'=>$menu];
            }

            // gestion si absence de lien
            if (!isset($menu['link'])) {
                $menu['link'] = "#";
            }

            $content    = Hash::get($menu, 'content', "&nbsp;");
            $link       = Hash::get($menu, 'link');
            unset($menu['content']);
            unset($menu['link']);
            return $this->link($content, $link, $menu);
        })->toArray();

        $menu = $this->ul($menu, [
            'class' => "dropdown-menu"
        ]);

        if ($options['tag']) {
            return $this->tag($options['tag'], $button.$menu, ['class'=>"dropdown"]);
        } else {
            return $button.$menu;
        }
    }

    public function icon($name, array $options = [])
    {
        return $this->fa($name, $options);
    }

    public function fa($name, array $options = [])
    {
        $options += [
            'iconSet'       => "fa",
            'isFixedWidth'  => true,
            'size'          => 1,
        ];

        $classes = [];

        // size, included in the custom css
        if (in_array($options['size'], ['lg',2,3,4,5])) {
            $size = "fa-".str_pad($options['size'], 2, "x");
            $classes[] = $size;
        }
        unset($options['size']);

        // fixed width
        if ($options['isFixedWidth']) {
            $classes[] = "fa-fw";
        }
        unset($options['isFixedWidth']);

        $options = $this->injectClasses($classes, $options);

        return $this->gi($name, $options);
    }

    public function gi($name, array $options = [])
    {
        $options += [
            'size'      => 1,
            'spaceAfter'=> true
        ];

        // size, included in the custom css
        if ($options['size']>1) {
            $size = "gi-".$options['size']."x";
            $options = $this->injectClasses($size, $options);
        }
        unset($options['size']);

        // generate a space after the icon automatically
        $spaceAfter = "";
        if ($options['spaceAfter']) {
            $spaceAfter = " ";
        }
        unset($options['spaceAfter']);

        return parent::icon($name, $options).$spaceAfter;
    }


    public function navbar($navbars, $options)
    {
        $options += [
            'type' => "default" // default, inverse
        ];

        // classes
        $options = $this->injectClasses(['navbar','navbar-'.$options['type']], $options);
        unset($options['type']);

        $navAll = collection($navbars)->buffered();

        // header
        // on filtre les elements ayant la key brand
        $navHeader = $navAll->filter(function ($nav) {
            return isset($nav['brand']);
        })->reduce(function ($reducer, $nav) {
            list($brand,$brandOptions) = $this->_extractContentOptions($nav['brand']);
            $brandOptions = $this->injectClasses("navbar-brand", $brandOptions);
            if (isset($nav['link'])) {
                $reducer .= $this->link($brand, $nav['link'], $brandOptions);
            } else {
                $reducer .= $this->tag('span', $brand, $brandOptions);
            }
            return $reducer;
        }, "");

        if (!empty($navHeader)) {
            $navHeader = $this->div('navbar-header', $navHeader);
        }

        // nav
        $nav = $navAll->reject(function ($nav) {
            return isset($nav['brand']);
        })->map(function ($nav) {
            list($li,$liOptions) = $this->_extractContentOptions($nav['content']);

            // est ce qu'on as un sous menu ?
            if (isset($nav['menu'])) {
                $liOptions = $this->injectClasses("dropdown", $liOptions);
                $dropdown = $this->dropdown([
                    'content'   => $li
                    ,'menu'     => $nav['menu']
                ], [
                    'tag'           => false,
                    'tagContent'    => ["a",['href'=>"#"]]
                ]);
                $content = [$dropdown,$liOptions];
            } else {
                // isActive
                if (Hash::get($nav, 'isActive')) {
                    $liOptions = $this->injectClasses("active", $liOptions);
                }

                // content, link, isActive -> <a>
                if (isset($nav['link'])) {
                    $content = [$this->link($li, $nav['link']),$liOptions];
                } else {
                    $content = [$this->tag('p', $li, ['class'=>'navbar-text']),$liOptions];
                }
            }

            return $content;
        });
        
        if (!empty($nav)) {
            $nav = $this->ul($nav, [
                'class'=> ['nav','navbar-nav']
            ]);
        }
        // nav-right


        return $this->tag('nav', $navHeader.$nav, $options);
    }
    /*
    gestion d'une barre de tabulations

    exemple :
    [
        [
            'tab' => titre de l'onglet, //peut contenir html .. etc
            'content' => contenu html,
            ,'isActive' => false, // par defaut lepremier onglet est mis a true si tous a false
        ],
        ...
    ]
    TODO : isActive sur menu
    TODO : gestion de l'alignement

    */
    private function _navTabsTab($navTabs)
    {
        return implode("", collection($navTabs)->map(function ($navTab) {
            $navOptions = $navTab + [
            ];
            unset($navOptions['content']);

            // gestion si element active selectionné
            if (Hash::get($navTab, 'isActive')===true) {
                $navOptions = $this->injectClasses('active', $navOptions);
            }
            unset($navOptions['isActive']);

            // ecriture de l'entete de onglet
            if (isset($navTab['menu'])) {
                $navTab['content'] = $navTab['tab'];
                unset($navTab['tab']);

                return $this->dropdown($navTab, [
                    'tag'           => "li"
                    ,'tagContent'   => ["a",['href'=>"#"]]
                ]);
            } elseif (isset($navTab['tab'])) {
                $tab = $this->link(
                    $navTab['tab'],
                    '#'.$navOptions['id'],
                    ['data-toggle'=>"tab"]
                );

                unset($navOptions['id']);
                unset($navOptions['tab']);

                return $this->tag('li', $tab, $navOptions)."\n";
            } else {
                // ni menu, ni tab ... title ?
                list($title,$titleOptions) = $this->_extractContentOptions($navTab['title']);
                return $this->tag('li', $title, $titleOptions);
            }
        })->toArray());
    }
    /*
        generation des content d'onglet

        <!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">...</div>
    <div role="tabpanel" class="tab-pane" id="profile">...</div>
    <div role="tabpanel" class="tab-pane" id="messages">...</div>
    <div role="tabpanel" class="tab-pane" id="settings">...</div>
  </div>

    */
    private function _navTabsContent($navTabs)
    {
        return implode("", collection($navTabs)->map(function ($navTab) {
            $contentOptions = $navTab + [
                //'role'  => "tabpanel",
            ];

            // on ignore les elements
            unset($contentOptions['title']);
            unset($contentOptions['tab']);
            unset($contentOptions['menu']);

            // on ajoute la classe
            $contentOptions = $this->injectClasses(['tab-pane'], $contentOptions);

            // gestion si element active selectionné
            if (Hash::get($navTab, 'isActive')===true) {
                $contentOptions = $this->injectClasses('active', $contentOptions);
            }
            unset($contentOptions['isActive']);

            // ecriture du contenu
            $content = Hash::get($navTab, 'content', "&nbsp;");
            unset($contentOptions['content']);

            
            

            return $this->tag('div', $content, $contentOptions);
        })->toArray());
    }

    public function navTabs($navTabs, array $options = [])
    {
        $templateDefault = "{{tabs}}{{contents}}";
        $options += [
            'type'          => "tabs",
            'template'      => $templateDefault,
            'align'         => "left",
            'isJustified'   => false
        ];

        $ulClasses = ["nav","nav-".$options['type']];
        unset($options['type']);

        if ($options['isJustified']) {
            $ulClasses += "nav-justified";
        }
        
        $options = $this->injectClasses($ulClasses, $options);

        // gestion onglet actif
        // si aucun onglet actif
        if (is_null(collection($navTabs)->firstMatch(['isActive' => true]))) {
            //on prends le premier ou tab exist
            $activeAdded = false;
            $navTabs = collection($navTabs)->map(function ($navTab) use (&$activeAdded) {
                if (!$activeAdded && isset($navTab['tab'])) {
                    $activeAdded = true;
                    return Hash::insert($navTab, 'isActive', true);
                }
                return $navTab;
            })->toArray();
        }

        // injection d'id si necessaire
        $navTabs = collection($navTabs)->map(function ($navTab) {
            return $navTab+[
                'id'    => uniqid("nt")
            ];
        })->toArray();

        // gestion du template
        list($template,$templateVars) = $this->_extractContentOptions($options['template'], $templateDefault);
        unset($options['template']);
        $this->templater()->add(['navtabs'=>$template]);

        return $this->templater()->format('navtabs', [
            'tabs'      => $this->tag('ul', $this->_navTabsTab($navTabs), $options),
            'contents'  => $this->div('tab-content', $this->_navTabsContent($navTabs))
        ]+$templateVars);
    }

    public function panel($content = "", array $options = [])
    {
        $options += [
            'title'     => false,
            'type'      => "default",
            'foot'      => false,
            'table'     => false,
            'list'      => false,
            'content'   => false
        ];

        $head = "";
        if ($options['title']) {
            $head .= $options['title'];
        }
        unset($options['title']);

        if (!empty($head)) {
            $head = $this->div('panel-heading', $head);
        }

        $body = "";
        if ($content) {
            $body = $this->div('panel-body', $content);
        }

        $foot = "";
        if (!empty($foot)) {
            $foot = $this->div('panel-footer', $foot);
        }

        $content = "";
        if ($options['table']) {
            $content .= call_user_func_array([$this,"table"], $options['table']);
        }


        if ($options['list']) {
            $content .= call_user_func_array([$this,"listGroup"], $options['list']);
        }

        if ($options['content']) {
            $content .= $options['content'];
        }

        return $this->div('panel panel-'.$options['type'], $head.$body.$foot.$content);
    }

    public function panelTabs($panelTabs, array $options = [])
    {
        $options += [
            'type'=>"default"
        ];
        
        // gestion du title
        $panelTabs = collection($panelTabs)->map(function ($panelTab) {
            if (isset($panelTab['title']) && is_string($panelTab['title'])) {
                $panelTab['title'] = [
                    $panelTab['title'],
                    ['class'=>"panel-title"]
                ];
            }
            return $panelTab;
        })->toArray();

        return $this->navTabs($panelTabs, [
            'template' => [
                '<div class="panel panel-{{type}} with-nav-tabs">'
                    .'<div class="panel-heading">{{tabs}}</div>'
                    .'<div class="panel-body">{{contents}}</div>'
                .'</div>',
                $options
            ]
        ]);
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

    /*
        genere une row avec nbCols
    */
    public function row($cols, array $options = [])
    {
        $nbCols =  count($cols);
        $options += [
            'width' => floor(12/$nbCols)
        ];

        // generation de taille de colonnes
        if (is_array($options['width'])) {
            $widths = $options['width'];
        } else {
            $widths = array_fill(0, $nbCols, $options['width']);
        }

        //debug($widths);

        $html = collection($cols)->reduce(function ($reducer, $col, $index) use ($widths) {
            return $reducer.$this->div('col col-md-'.$widths[$index], $col);
        }, "");

        return $this->div('row', $html);
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
