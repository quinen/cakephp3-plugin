<?php

// list all the icon inside the css file
function getIcons($url, $regex)
{
    // get the file
    $file = file_get_contents($url);
    
    $icons = [];
    // parse regex /.glyphicon-(.*):/
    if (preg_match_all($regex, $file, $m)) {
        // store in a an array all the icons
        $icons = $m[1];
    } else {
        $html .= "nothing found";
    }
    sort($icons);
    return $icons;
}

$fas = getIcons("https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css", "/.fa-([^:]*):before/");
$gis = getIcons("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css", "/.glyphicon-([^:]*):before/");

// intersect
$intersect = array_intersect($fas, $gis);
$fas = array_diff($fas, $intersect);
$gis = array_diff($gis, $intersect);

// brands
$brands = "amazon,android,angellist,bandcamp,behance,behance-square,bitbucket,bitbucket-square,".
    "buysellads,chrome,cny,codepen,codiepie,connectdevelop,contao,dashcube,dedent,delicious,".
    "deviantart,digg,dropbox,drupal,edge,eercast,empire,envira,expeditedssl,facebook,".
    "facebook-f,facebook-official,facebook-square,firefox,first-order,fonticons,forumbee,".
    "foursquare,free-code-camp,ge,get-pocket,gg,gg-circle,git,git-square,github,github-alt,".
    "github-square,gitlab,glide,glide-g,google,google-plus,google-plus-circle,google-plus-official,".
    "google-plus-square,google-wallet,gittip,gratipay,grav,h-square,hacker-news,houzz,".
    "ils,imdb,inr,instagram,internet-explorer,ioxhost,joomla,jsfiddle,lastfm,lastfm-square,".
    "leanpub,linkedin,linkedin-square,linode,linux,maxcdn,meanpath,medium,meetup,mixcloud,".
    "modx,odnoklassniki,odnoklassniki-square,opencart,openid,opera,optin-monster,paypal,".
    "pied-piper,pied-piper-alt,pied-piper-pp,pinterest,pinterest-p,pinterest-square,product-hunt,qq,quora,ra,ravelry,rebel,reddit,reddit-alien,reddit-square"
;
$brands = explode(',', $brands);
$fas = array_diff($fas, $brands);

// alias FA > GI
$alias = [
    'arrow-circle-down'     => 'circle-arrow-down',
    'arrow-circle-left'     => 'circle-arrow-left',
    'arrow-circle-right'    => 'circle-arrow-right',
    'arrow-circle-up'       => 'circle-arrow-up',
    'ban'                   => "ban-circle",
    'ellipsis-h'            => "option-horizontal",
    'ellipsis-v'            => "option-vertical",
    'exclamation-triangle'  => "alert",
    'warning'               => "alert",
];
$fas = array_diff($fas, array_keys($alias));
$gis = array_diff($gis, array_values($alias));

$htmlFa = implode("\n", collection($fas)->map(function ($v) {
    return $this->Html->fa($v, ['size'=>2,'title'=>$v,'spaceAfter'=>true]);
})->toArray());
$htmlBrands = implode("\n", collection($brands)->map(function ($v) {
    return $this->Html->fa($v, ['size'=>2,'title'=>$v,'spaceAfter'=>true]);
})->toArray());

$htmlGi = implode("\n", collection($gis)->map(function ($v) {
    return $this->Html->gi($v, ['size'=>2,'title'=>$v,'spaceAfter'=>true]);
})->toArray());

$htmlAlias = implode("\n", collection($alias)->map(function ($v, $k) {
    return $this->Html->row([
        $k,
        $this->Html->fa($k,['size'=>2,'title'=>$k]),
        $this->Html->gi($v,['size'=>2,'title'=>$v]),
        $v
    ], ['width'=>[4,2,2,4]]);
})->toArray());

$htmlIntersect = implode("\n", collection($intersect)->chunk(3)->map(function ($v) {
    return $this->Html->row(
        collection($v)->map(function ($v) {
            return [
                $this->Html->fa($v, ['size'=>2,'title'=>$v,'spaceAfter'=>true]),
                $this->Html->gi($v, ['size'=>2,'title'=>$v,'spaceAfter'=>true]),
                $this->Html->div('text-nowrap', $v)
            ];
        })->unfold()->toArray(),
        [
            'width' => [1,1,2,1,1,2,1,1,2]
        ]
    );
})->toArray());

$panelFa        = $this->Html->panel($htmlFa, ['title'=>"Font-Awesome"]);
$panelBrands    = $this->Html->panel($htmlBrands, ['title'=>"Brands"]);
$panelGi        = $this->Html->panel($htmlGi, ['title'=>"Glyphicons"]);
$panelAlias     = $this->Html->panel($htmlAlias, ['title'=>"Alias"]);
$panelIntersect = $this->Html->panel($htmlIntersect, ['title'=>"Communs (FA GI)"]);

echo $this->Html->row([$panelFa.$panelBrands,$panelGi.$panelAlias,$panelIntersect]);
