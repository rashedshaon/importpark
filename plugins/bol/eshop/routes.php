<?php
Route::get('sitemap.xml', function()
{
    return response(file_get_contents(resource_path('sitemap.xml')), 200, [
        'Content-Type' => 'application/xml'
    ]);
});


Route::get('robots.txt', function()
{
    return response(file_get_contents(resource_path('robots.txt')), 200, [
         'Content-Type' => 'text/plain'
    ]);
});


?>