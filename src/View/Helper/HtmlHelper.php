<?php
namespace Quinen\View\Helper;

use BootstrapUI\View\Helper\HtmlHelper as UseHelper;
use Cake\Utility\Hash;

class HtmlHelper extends UseHelper
{
    public function button($type = "default", $options = [])
    {
        $classes = ['btn', 'btn-' . $type];

        return $this->tag('button', $type, $this->injectClasses($classes, $options));
    }

    public function icon($name, array $options = [])
    {
        $options += [
            'size'      => 1,
            'spaceAfter'=> true
        ];

        // size, included in the custom css
        if ($options['size']>1) {
            $size = "gi-".$options['size']."x";
            $options = $this->injectClasses($size, $options);
            unset($options['size']);
        }

        $html = parent::icon($name, $options);

        // generate a space after the icon automatically
        if ($options['spaceAfter']) {
            $html .= "&nbsp;";
        }
        return $html;
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

    */
    private function _navTabsTab($navTabs)
    {
        return implode("", collection($navTabs)->map(function ($navTab) {
            $navOptions = $navTab + [
                //'role'  => "presentation",
                
            ];
            // gestion si element active selectionné
            if (Hash::get($navTab, 'isActive')===true) {
                $navOptions = $this->injectClasses('active', $navOptions);
            }

            // ecriture de l'entete de onglet
            $tab = $this->link(
                $navTab['tab'],
                '#'.$navOptions['id'],
                ['data-toggle'=>"tab"]
            );

            unset($navOptions['id']);
            unset($navOptions['tab']);
            unset($navOptions['menu']);
            unset($navOptions['content']);
            unset($navOptions['isActive']);

            return $this->tag('li', $tab, $navOptions)."\n";
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

            $contentOptions = $this->injectClasses(['tab-pane'], $contentOptions);

            // gestion si element active selectionné
            if (Hash::get($navTab, 'isActive')===true) {
                $contentOptions = $this->injectClasses('active', $contentOptions);
            }

            // ecriture de l'entete de onglet
            $content = Hash::get($navTab, 'content');

            unset($contentOptions['tab']);
            unset($contentOptions['menu']);
            unset($contentOptions['content']);
            unset($contentOptions['isActive']);

            return $this->tag('div', $content, $contentOptions);
        })->toArray());
    }
    public function navTabs($navTabs, array $options = [])
    {
        $templateDefault = "{{tabs}}{{contents}}";
        $options += [
            'type'  => "tabs",
            'template'   => $templateDefault,
        ];

        $ulClasses = ["nav","nav-".$options['type']];
        unset($options['type']);
        
        $options = $this->injectClasses($ulClasses, $options);

        // on gere les entete d'onglets
        // on doit determiner l'onglet actif ..
        // on parcours donc le tableau en esperant trouver un actif, si aucun on selectionne le premier
        if (is_null(collection($navTabs)->firstMatch(['isActive' => true]))) {
            $navTabs[0]['isActive'] = true;
        }

        // injection d'id si necessaire
        $navTabs = collection($navTabs)->map(function ($navTab) {
            return $navTab+[
                'id'    => uniqid("nt")
            ];
        })->toArray();

        // gestion du template
        $templateVars = [];
        if (is_array($options['template'])) {
            $templateVars        = Hash::get($options, 'template.1', []);
            $options['template'] = Hash::get($options, 'template.0', $templateDefault);
        }
        $this->templater()->add(['navtabs'=>$options['template']]);
        unset($options['template']);

        $html = $this->templater()->format('navtabs', [
            'tabs'      => $this->tag('ul', $this->_navTabsTab($navTabs), $options),
            'contents'  => $this->div('tab-content', $this->_navTabsContent($navTabs))
        ]+$templateVars);
        return  $html;
    }

    public function panelTabs($panelTabs,array $options = []){
        $options += [
            'type'=>"default"
        ];
        
        return $this->navTabs($panelTabs,[
            'template' => [
                '<div class="panel with-nav-tabs panel-{{type}}">'
                .'<div class="panel-heading">{{tabs}}</div>'
                .'<div class="panel-body">{{contents}}</div>'
                .'</div>',
                $options
            ]
        ]);
    }
}
