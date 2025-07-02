<?php

namespace App\Http\Controllers\Articles;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleCommentFormRequest;
use App\Models\Articles\WebsiteArticle;
use App\Models\Articles\WebsiteArticleComment;
use App\Services\Articles\CommentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class WebsiteArticleCommentsController extends Controller
{
    public function __construct(public readonly CommentService $commentService) {}

    public function store(WebsiteArticle $article, ArticleCommentFormRequest $request): RedirectResponse
	{
		try {
			$this->commentService->store($request->get('comment'), $article);
			return redirect()->route('article.show', $article->slug)->with('success', __('You comment has been posted!'));} catch (\Exception $e) {
			return redirect()->route('article.show', $article->slug)->withErrors(['error' => __('Failed to post comment. Please try again.')]);
		}
	}

    public function destroy(WebsiteArticleComment $comment): RedirectResponse
    {
        $this->commentService->destroy($comment);
        return redirect()->back()->with('success', __('You comment has been deleted!'));
    }
}
