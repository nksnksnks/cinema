<?php

namespace App\Repositories\user\Comment;

use App\Models\Evaluate;
use App\Repositories\user\Movie\MovieRepository;
use Illuminate\Support\Facades\DB;

class CommentRepository
{
    public function createComment($data, $accountId)
    {
        $comment = Evaluate::where('account_id', $accountId)->where('movie_id', $data['movie_id'])->first();
        if($comment){
            $status = 'update';
            $data = Evaluate::find($comment['id'])->update([
                'movie_id' => $data['movie_id'],
                'vote_star' => $data['vote_star'],
                'comment' => $data['comment']
            ]);
            return [
                'data' => $comment,
                'status' => $status
            ];
        }
        else{
            $status = 'create';
            $data = Evaluate::create([
                'account_id' => $accountId,
                'movie_id' => $data['movie_id'],
                'vote_star' => $data['vote_star'],
                'comment' => $data['comment']
            ]);
            return [
                'data' => $data,
                'status' => $status
            ];
        }

    }
    public function getComment($movieId, $accountId = null)
    {
        $comment = [];
        
        $first = DB::table('ci_evaluate as e')
            ->select('e.id', 'e.account_id', 'e.comment', 'e.vote_star', 'e.created_at', 'p.name', 'p.avatar')
            ->join('ci_profile as p', 'p.account_id', '=', 'e.account_id')
            ->where('e.movie_id', $movieId)
            ->where('e.account_id', $accountId)
            ->first();
        
        if ($first) {
            $comment[] = $first;
        }

        $data = DB::table('ci_evaluate as e')
            ->select('e.account_id', 'e.comment', 'e.vote_star', 'e.created_at', 'p.name', 'p.avatar', 'e.id')
            ->join('ci_profile as p', 'p.account_id', '=', 'e.account_id')
            ->where('e.movie_id', $movieId)
            ->where('e.account_id', '<>', $accountId)
            ->orderBy('created_at', 'DESC')
            ->get();

        foreach ($data as $d) {
            $comment[] = [
                'id' => $d->id,
                'account_id' => $d->account_id,
                'comment' => $d->comment,
                'vote_star' => $d->vote_star,
                'created_at' => $d->created_at,
                'name' => $d->name,
                'avatar' => $d->avatar,
            ];
        }

        return $comment;
    }
    public function deleteComment($movieId, $accountId = null)
    {
        $comment = DB::table('ci_evaluate')->where('movie_id', $movieId)->where('account_id', $accountId)->first();
        $delete = DB::table('ci_evaluate')->where('movie_id', $movieId)->where('account_id', $accountId)->delete();
        return $comment;
    }
}
