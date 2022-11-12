<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Account extends Authenticatable 
{
    use Notifiable;
    public function posts() {
        return $this->hasMany('App\Post');
    }
    public function getByAccount(){
        return $this->posts()->first();
    }
    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'following_id');
    }

    public function follows()
    {
        return $this->belongsToMany(self::class, 'followers', 'following_id', 'followed_id');
    }
    // フォローする
    public function follow(Int $user_id) 
    {
        return $this->follows()->attach($user_id);
    }

    // フォロー解除する
    public function unfollow(Int $user_id)
    {
        return $this->follows()->detach($user_id);
    }

    // フォローしているか
    public function isFollowing(Int $user_id) 
    {
        return (boolean) $this->follows()->where('followed_id', $user_id)->first(['id']);
    }

    // フォローされているか
    public function isFollowed(Int $user_id) 
    {
        return (boolean) $this->followers()->where('following_id', $user_id)->first(['id']);
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'taiko_id', 'password', 'pref_id', 'rank_id', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'taiko_id_verified_at' => 'datetime',
    ];
    
    public static $rules = [
        'name' => ['required', 'string', 'max:10'],
        'taiko_id' => ['required', 'regex:/^[0-9]{12}$/', 'unique:accounts'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'pref_id' => ['required'],
        'rank_id' => ['required'],
        'email' => ['required', 'string', 'email:rfc', 'max:255']
    ];
    public static $messages = [
        'name.required' => 'お名前を入力してください。',
        'name.max' => 'お名前は10文字以内で入力してください。',
        'taiko_id.required' => '太鼓番を入力してください。',
        'taiko_id.taiko_id' => '太鼓番を正しく入力してください。',
        'taiko_id.unique' => 'その太鼓番は既に使用されています。',
        'password.required' => 'パスワードを入力してください。',
        'password.min' => 'パスワードは8文字以上で入力してください。',
        'password.confirmed' => '入力されたパスワードが一致しません。',
        'pref_id.required' => '都道府県を選択してください。',
        'rank_id.required' => '段位を選択してください。',
        
    ];
    
    public static $prefs = [
        1 => '北海道',
        2 => '青森県', 3 => '岩手県', 4 => '宮城県', 5 => '秋田県', 6 => '山形県', 7 => '福島県',
        8 => '茨城県', 9 => '栃木県', 10 => '群馬県', 11 => '埼玉県', 12 => '千葉県', 13 => '東京都', 14 => '神奈川県',
        15 => '新潟県', 16 => '富山県', 17 => '石川県', 18 => '福井県', 19 => '山梨県', 20 => '長野県',
        21 => '岐阜県', 22 => '静岡県', 23 => '愛知県', 24 => '三重県',
        25 => '滋賀県', 26 => '京都府', 27 => '大阪府', 28 => '兵庫県', 29 => '奈良県', 30 => '和歌山県',
        31 => '鳥取県', 32 => '島根県', 33 => '岡山県', 34 => '広島県', 35 => '山口県',
        36 => '徳島県', 37 => '香川県', 38 => '愛媛県', 39 => '高知県',
        40 => '福岡県', 41 => '佐賀県', 42 => '長崎県', 43 => '熊本県', 44 => '大分県', 45 => '宮崎県', 46 => '鹿児島県', 47 => '沖縄県',
    ];
    public static $ranks = [
        1 => 'なし',
        2 => '達人', 3 => '超人', 4 => '名人', 5 => '玄人', 6 => '十段', 7 => '九段',
        8 => '八段', 9 => '七段', 10 => '六段', 11 => '五段', 12 => '四段', 13 => '三段', 14 => '二段',
        15 => '初段', 16 => '一級', 17 => '二級', 18 => '三級', 19 => '四級', 20 => '五級',
 
    ];
}
