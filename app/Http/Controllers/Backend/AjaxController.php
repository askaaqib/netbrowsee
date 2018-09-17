<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\TagRepository;
use App\Repositories\Contracts\LabourRateRepository;
use App\Repositories\Contracts\MaterialRateRepository;
use App\Repositories\Contracts\VatRepository;
use App\Repositories\Contracts\PostRepository;
use Mcamara\LaravelLocalization\LaravelLocalization;

class AjaxController extends Controller
{
    /**
     * @var PostRepository
     */
    protected $posts;

    /**
     * @var TagRepository
     */
    protected $tags;

    /**
     * @var LaravelLocalization
     */
    protected $localization;

    /**
     * AjaxController constructor.
     *
     * @param \App\Repositories\Contracts\PostRepository       $posts
     * @param TagRepository                                    $tags
     * @param \Mcamara\LaravelLocalization\LaravelLocalization $localization
     */
    public function __construct(PostRepository $posts, TagRepository $tags, LaravelLocalization $localization)
    {
        $this->posts = $posts;
        $this->tags = $tags;
        $this->localization = $localization;
    }

    /**
     * Global index search.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        return empty($query) ? [] : $this->posts->search($query)->take(50)->get();
    }

    /**
     * Search internal transatables routes.
     *
     * @param Request $request
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function routesSearch(Request $request)
    {
        $items = [];

        $routes = __('routes');

        foreach ($routes as $name => $uri) {
            $items[$name] = $uri;
        }

        return [
            'items' => $items,
        ];
    }

    /**
     * Search tags.
     *
     * @param Request $request
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function tagsSearch(Request $request)
    {
        $query = $request->get('q');

        $locale = app()->getLocale();

        return [
            'items' => $this->tags->query()
                ->where("name->{$locale}", 'like', "%$query%")
                ->pluck('name'),
        ];
    }

    /**
     * Search labour.
     *
     * @param Request $request
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function getLabourRates(Request $request, LabourRateRepository $labour)
    {

        return [
            'ids' => $labour->query()
                ->where('id' ,'>' ,0)
                ->pluck('rate')
        ];
    }

    /**
     * Search material.
     *
     * @param Request $request
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function getMaterialRates(Request $request, MaterialRateRepository $material)
    {

        return [
            'ids' => $material->query()
                ->where('id' ,'>' ,0)
                ->pluck('rate')
        ];
    }

    /**
     * Search vat.
     *
     * @param Request $request
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    public function getVatRates(Request $request, VatRepository $vat)
    {

        return [
            'ids' => $vat->query()
                ->where('id' ,'>' ,0)
                ->pluck('rate')
        ];
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function imageUpload(Request $request)
    {
        $uploadedImage = $request->file('upload');

        // Resize image below 600px width if needed
        $image = Image::make($uploadedImage->openFile())->widen(600, function ($constraint) {
            $constraint->upsize();
        });

        $imagePath = "/tmp/{$uploadedImage->getClientOriginalName()}";
        Storage::disk('public')->put($imagePath, $image->stream());

        return [
            'uploaded' => true,
            'url'      => "/storage{$imagePath}",
            'width'    => $image->width(),
            'height'   => $image->height(),
        ];
    }
}
