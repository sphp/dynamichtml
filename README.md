# dynamichtml
Super simple lite dynamic html generator class

Example use:
echo html::form(['method:get', 'action'=>''])
->span(['id:pass'],'Username')
    ->input(['type:text','name:user', "id:user", "placeholder:Username"])
    ->div(["id:append", "class:append"],'append')
    ->input(['type:password','name:pass', "id:pass", "placeholder:Password"])
    ->span(['id:pass'],'Select multiple')
    ->select(['name:cars','size:4', 'multiple:multiple'], ["img", "br", "hr", "input", "area"])
    ->span(['id:pass'],'Select Single')
    ->select(['name:cars'], ["img", "br", "hr", "input", "area", "link", "meta", "param"])
    ->radio(['name:cars'], ['img'=>'Image', "br", "hr"])
    ->cheakbox(['name:cars'], ['img'=>'Image','link'=>'Imlinkage', 'input'=>'inlinkput'])
    ->input(['type:submit','value:submit'])
    ->fieldset('Signup');
