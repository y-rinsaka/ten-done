<?php

namespace App\Http\Controllers;
use App\Http\Requests\AccountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Account;
use App\Difficulty;
use App\Chart;
use App\Genre;
class AccountController extends Controller
{
    public function index(Chart $chart, Difficulty $difficulty, Genre $genre)
    {
        return view('account.index')->with(['charts' => $chart->get(), 'difficulties' => $difficulty->get(),
                                        'genres' => $genre->get()]);;
    }
    public function edit($id)
    {
        return view('account.edit');
    }
    public function update(AccountRequest $request, Account $account)
    {
        $account->fill($request->all());
    
        // パスワードの項目があるとき（つまり、パスワードを変更するとき）
        if (!is_null($request->password)) {
            // パスワードの値をハッシュ化して上書きする。
            $account->password = Hash::make($request->password);
        } else {
            // パスワードの項目に値がないときは、アップデートの対象にしない。
            unset($account->password);
        }
        $account->save();
        return redirect(route('account.index'));
    }
}
