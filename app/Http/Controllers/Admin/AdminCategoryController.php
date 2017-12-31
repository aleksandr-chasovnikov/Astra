<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Model\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AdminCategoryController extends BaseController
{
    /**
     * @return View
     */
    public function index()
    {
        self::checkAdmin();

        $categories = Category::withTrashed()
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.category.index')->with([
            'categories' => $categories,
        ]);
    }

    /**
     * Сохраняет категорию
     *
     * POST /admin/category/store
     *
     * @param Request $request
     *
     * @return RedirectResponse | HttpException
     */
    public function store(Request $request)
    {
        self::checkAdmin();

        $this->validate($request, [
            'title' => 'required|max:255',
        ]);

        Category::query()
            ->create($request->all());

        return redirect()->back();
    }

    /**
     * Редактирует категорию
     *
     * POST /admin/category/update
     *
     * @param Request $request
     *
     * @return RedirectResponse | HttpException
     */
    public function update(Request $request)
    {
        self::checkAdmin();

        $this->validate($request, [
            'title' => 'required|max:255',
        ]);

        Category::find($request->id)
            ->update($request->all());

        return redirect()->back();
    }

    /**
     * Удаляет категорию
     *
     * DELETE /admin/category/delete/{id}
     *
     * @param $id
     *
     * @return RedirectResponse | HttpException
     */
    public function destroy($id)
    {
        self::checkAdmin();

        Category::find($id)->delete();

        return redirect()->back();
    }

    /**
     * Восстанавливает категорию
     *
     * GET /admin/category/restore/{id}
     *
     * @param $id
     *
     * @return RedirectResponse | HttpException
     */
    public function restore($id)
    {
        self::checkAdmin();

        Category::withTrashed()
            ->where('id', $id)
            ->restore();

        return redirect()->back();
    }

}
