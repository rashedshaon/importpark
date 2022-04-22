<?php namespace Bol\Eshop\Models;

use Str;
use BackendAuth;
use Backend\Models\ImportModel;
use System\Models\File;

class ProductImport extends ImportModel
{

    /**
     * @var array The rules to be applied to the data.
     */
    public $rules = [
        'id' => 'required',
        'title' => 'required',
        'slug' => 'required',
    ];

    public function importData($results, $sessionKey = null)
    {
        foreach ($results as $row => $data) 
        {
            try {
                
                $product = Product::find($data['id']);

                if($product)
                {
                    $product->id = $this->filter($data['id']);
                    $product->title = $this->filter($data['title']);
                    $product->slug = $data['slug'];
                    $product->short_description = $this->filter($data['short_description']);
                    $product->description = $this->filter($data['description']);
                    $product->brand_id = $this->getBrandId($data['brand']);
                    $product->unit_id = $this->getUnitId($data['unit']);
                    $product->video_url = $this->filter($data['video_url']);
                    $product->page_view = $this->filter($data['page_view']);
                    $product->view = $this->filter($data['view']);
                    $product->sizes = $this->filter($data['sizes']) ?: '[]';
                    $product->colors = $this->filter($data['colors']) ?: '[]';
                    $product->weight = $this->filter($data['weight']);
                    $product->type = $this->filter($data['type']);
                    $product->price = $this->filter($data['price']);
                    $product->discount = $data['discount'] ? : 0;
                    $product->discount_type = $this->filter($data['discount_type']);
                    // $product->discount_start = $this->filter($data['discount_start']);
                    // $product->discount_end = $this->filter($data['discount_end']);
                    $product->meta_title = $this->filter($data['meta_title']);
                    $product->meta_description = $this->filter($data['meta_description']);
                    $product->is_featured = $this->filter($data['is_featured']);
                    $product->is_published = $this->filter($data['is_published']);
                    $product->published_at = $this->filter($data['published_at']);

                    $product->save();


                    $this->logUpdated();
                }else{

                    $product = new Product();
                    $product->id = $this->filter($data['id']);
                    $product->title = $this->filter($data['title']);
                    $product->slug = $data['slug'];
                    $product->short_description = $this->filter($data['short_description']);
                    $product->description = $this->filter($data['description']);
                    $product->brand_id = $this->getBrandId($data['brand']);
                    $product->unit_id = $this->getUnitId($data['unit']);
                    $product->video_url = $this->filter($data['video_url']);
                    $product->page_view = $this->filter($data['page_view']);
                    $product->view = $this->filter($data['view']);
                    $product->sizes = $this->filter($data['sizes']) ?: '[]';
                    $product->colors = $this->filter($data['colors']) ?: '[]';
                    $product->weight = $this->filter($data['weight']);
                    $product->type = $this->filter($data['type']);
                    $product->price = $this->filter($data['price']);
                    $product->discount = $data['discount'] ? : 0;
                    $product->discount_type = $this->filter($data['discount_type']);
                    // $product->discount_start = $this->filter($data['discount_start']);
                    // $product->discount_end = $this->filter($data['discount_end']);
                    $product->meta_title = $this->filter($data['meta_title']);
                    $product->meta_description = $this->filter($data['meta_description']);
                    $product->is_featured = $this->filter($data['is_featured']);
                    $product->is_published = $this->filter($data['is_published']);
                    $product->published_at = $this->filter($data['published_at']);
    
                    $product->save();

                    if($data['photos'])
                    {
                        foreach(explode(',', $data['photos']) as $key => $url)
                        {
                            $file = new File;
                            $file->fromUrl($url, $product->slug.'-'.($key+1).'.jpg');
                            $product->photos()->add($file);
                        }
                    }

                    $this->logCreated();
                }
            }
            catch (\Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }

        }
    }

    public function filter($string)
    {
        $string = trim($string);
        return $string === false ? null : $string;
    }

    public function getBrandId($string)
    {
       if($string)
       {
           $brand = Brand::where('name', $string)->get()->first();
           if($brand)
           {
               return $brand->id;
           }
           else
           {
               $brand = new Brand();
               $brand->name = $string;
               $brand->slug = Str::slug($string, '-');
               $brand->save();

               return $brand->id;
           }
       }
    }

    public function getUnitId($string)
    {
       if($string)
       {
           $unit = Unit::where('name', $string)->get()->first();
           if($unit)
           {
               return $unit->id;
           }
           else
           {
               $unit = new Unit();
               $unit->name = $string;
               $unit->save();

               return $unit->id;
           }
       }
    }

    // public function getDivisionId($string)
    // {
    //    if($string)
    //    {
    //        $data = Division::where('name', $string)->get()->first();
    //        if($data)
    //        {
    //            return $data->id;
    //        }
    //        else
    //        {
    //            $data = new Division();
    //            $data->name = $string;
    //            $data->save();

    //            return $data->id;
    //        }
    //    }
    // }

    

}