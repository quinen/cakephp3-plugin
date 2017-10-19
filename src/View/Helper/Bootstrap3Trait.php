<?php

namespace Quinen\View\Helper;

use Cake\Utility\Hash;

trait Bootstrap3Trait
{
    //
    //  dropdown implementable dans des menus et boutons
    //
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

    public function button($type = "default", $options = [])
    {
        $classes = ['btn', 'btn-' . $type];

        return $this->tag('button', $type, $this->injectClasses($classes, $options));
    }

    // definition list
    // <dl>
    //     <dd></dd>
    //     <dt></dt>
    // </dl>
    // cle = valeur
    // question = reponse
    // []
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
      //    genere une row avec nbCols
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

    // gestion d'une barre de tabulations
    // exemple :
    // [
    //     [
    //         'tab' => titre de l'onglet, //peut contenir html .. etc
    //         'content' => contenu html,
    //         ,'isActive' => false, // par defaut lepremier onglet est mis a true si tous a false
    //     ],
    //     ...
    // ]
    // TODO : isActive sur menu
    // TODO : gestion de l'alignement
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

    //         generation des content d'onglet
    //         <!-- Tab panes -->
    // <div class="tab-content">
    //     <div role="tabpanel" class="tab-pane active" id="home">...</div>
    //     <div role="tabpanel" class="tab-pane" id="profile">...</div>
    //     <div role="tabpanel" class="tab-pane" id="messages">...</div>
    //     <div role="tabpanel" class="tab-pane" id="settings">...</div>
    //   </div>
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
        if (is_array($content)) {
            $content = Hash::get($content, 'content');
            unset($content['content']);
        }
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
}
