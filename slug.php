<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
class Slug
{
    /**
     * @param $title
     * @param int $id
     * @return string
     * @throws \Exception
     */
    public function createSlug($new_value, $current_value, $id = 0, $table, $slug_field = 'slug', $default_value = '')
    {
	    if(empty($new_value)){
			$new_value = $default_value; 
	    }
	    if($new_value != $current_value){
	        // Normalize the title
	        $slug = str_slug($new_value);
	        // Get any that could possibly be related.
	        // This cuts the queries down by doing it once.
	        $allSlugs = $this->getRelatedSlugs($slug, $id, $table, $slug_field);
	        // If we haven't used it before then we are all good.
	        if (! $allSlugs->contains($slug_field, $slug)){
	            return $slug;
	        }
	        // Just append numbers like a savage until we find not used.
	        for ($i = 1; $i <= 10; $i++) {
	            $newSlug = $slug.'-'.$i;
	            if (! $allSlugs->contains('slug', $newSlug)) {
	                return $newSlug;
	            }
	        }
	    }else{
		    return $current_value;
	    }
        throw new \Exception('Can not create a unique slug');
    }
    protected function getRelatedSlugs($slug, $id = 0, $table, $slug_field)
    {
        return DB::table($table)->select($slug_field)->where($slug_field, 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }
}
