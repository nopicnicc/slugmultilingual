# slugmultilingual
generate unique slug multilingual Laravel
```php
$slug = New Slug;
$item->slug_fr = $slug->createSlug($request->slug_fr, $item->slug_fr, $item->id, 'items', 'slug_fr', $request->name_fr);
```
createSlug(wantedSlug, current_slug, itemId, tableName, slugFieldName, defaultBaseStringIfNoWantedSlug)

Based on https://gist.github.com/ericlbarnes/3b5d3c49482f2a190619699de660ee9f
