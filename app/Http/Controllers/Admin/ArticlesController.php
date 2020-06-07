<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddArticleRequest;

class ArticlesController extends Controller
{
    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->header('X-Requested-With') === 'XMLHttpRequest') {

            $query = Article::where('id', '>', 0);
            // 日期搜索
            $datemin = $request->get('datemin');
            $datemax = $request->get('datemax');

            // 标题搜索
            $title = $request->get('title');

            // 列表排序(索引0是列，1是排序方式)
            list($column_index, $dir) = array_values($request->get('order')[0]);
            $orderField = $request->get('columns')[$column_index]['data'];

            if (!empty($title)) {
                $query->where('title', 'like', "%{$title}%");
            }

            if (!empty($datemin) && !empty($datemax)) {
                // 开始时间
                $datemin = date('Y-m-d H:i:s', strtotime($datemin . ' 00:00:00'));
                // 结束时间
                $datemax = date('Y-m-d H:i:s', strtotime($datemax . ' 23:59:59'));
                $query->whereBetween('created_at', [$datemin, $datemax]);
            }


            /* draw:
            客户端调用服务器端次数标识
            recordsTotal: 获取数据记录总条数
            recordsFiltered: 数据过滤后的总数量
            data: 获得的具体数据
            注意：recordsTotal和recordsFiltered都设置为记录的总条数
            */
            $start = $request->get('start', 0);
            $lenght = min(100, $request->get('length'));
            $count = $query->count();
            $articles = $query->orderBy($orderField, $dir)->offset($start)->limit($lenght)->get();
            $result = [
                'draw' => $request->get('draw'),
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
                'data' => $articles
            ];
            return $result;
        }
        return view('admin.articles.index');
    }

    /**
     * 添加文章
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * @param AddArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AddArticleRequest $request)
    {
        $pic = config('up.pic');
        if ($request->hasFile('pic')) {
            // store()中的article是config->filesystems.php中自定义的参数
            $pic = $request->file('pic')->store('', 'article');
        }
        $post = $request->except('_token');
        $post['pic'] = '/uploads/article/'.$pic;

        // 添加到数据库中
        Article::create($post);
        session()->flash('success', '文章添加成功');
        return redirect()->route('admin.articles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }
}
