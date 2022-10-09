<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>新譜面登録ページ</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>新譜面登録ページ</h1>
        <form action="/charts" method="POST">
        @csrf
        <div>
            <h2>譜面名</h2>
            <input type="text" name="chart[name]" placeholder="名前" />
        </div>
    
        <div>
            <h2>読み方（カタカナ）</h2>
            <input type="text" name="chart[name_kana]" placeholder="学年" />
        </div>
    
        <div>
            <h2>難易度</h2>
            <select name="chart[difficulty_id]">
                @foreach($difficulties as $difficulty)
                    <option value="{{ $difficulty->id }}">{{ $difficulty->difficulty }}</option>
                @endforeach
            </select>
        </div>
                
        <div>
            <p>ジャンル</p>
            @foreach($genres as $genre)
    
                <label>
                    {{-- valueを'$subjectのid'に、nameを'配列名[]'に --}}
                    <input type="checkbox" value="{{ $genre->id }}" name="genres_array[]">
                        {{$genre->name}}
                    </input>
                </label>
                
            @endforeach    
        
        </div>
            <input type="submit" value="保存"/>
          </form>
        
    </body>
</html>