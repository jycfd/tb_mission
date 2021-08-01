<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_3-5c</title>
    </head>
    <body>
        <?php
        //投稿機能
        //フォームが空でない場合に以下を実行
        if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass"])){
            //受け取ったデータを変数に代入
            $name=$_POST["name"];
            $comment=$_POST["comment"];
            $pass=$_POST["pass"];
            $filename="mission_3-5.txt";
            //日付データを取得して変数に代入
            $date=date("Y/m/d H:i:s");
            //editNoがないときは新規投稿、あるときは編集
            if(empty($_POST["editNO"])){
            //以下新規投稿機能   
            //ファイルがあったら1つずつ投稿番号をつける    
            $num=file_exists($filename)?
            1+count(file($filename)):1;
            //ファイルを追記保存モードでオープン
            $fp=fopen($filename,"a");
            //入力データをファイルに書き込む
            fwrite($fp,$num."<>".$name."<>".$comment."<>".$date."<>".$pass."<>".PHP_EOL);
            fclose($fp);
            }else{
                //以下編集機能
                //入力データの受け取りを変数に代入
                $editNO=$_POST["editNO"];
                
                //読み込んだファイルの中身を配列に格納する
                $ret_array=file($filename);
                //ファイルを書き込みモードでオープン、中身を空に
                $fp=fopen($filename,"w");
                //配列の数だけループさせる
                foreach($ret_array as $line){
                    //explode関数でそれぞれの値を取得
                    $data=explode("<>",$line);
                    //投稿番号と編集番号が一致したら
                    if($data[0]==$editNO && $data[4]==$pass){
                        //編集のフォームから送信された値と差し替えて上書き
                        fwrite($fp,$editNO."<>".$name."<>".$comment."<>".$date."<>".$pass."<>".PHP_EOL);
                    }else{
                        //一致しなかったところはそのまま書き込む
                        fwrite($fp,$line);
                    }
                } 
                fclose($fp);
            }
        }

 //削除機能
        //削除フォームが送信されたら
        if(!empty($_POST["deletenum"]) && !empty($_POST["passDel"])){
            //入力データを受け取り、変数に代入
            $delete=$_POST["deletenum"];
            $passDel=$_POST["passDel"];
            
            $filename = "mission_3-5.txt";
            
            //読み込んだファイルを配列に格納
            $delCon=file($filename);
            //1行ずつ調べる
            for($i=0;$i<count($delCon);$i++){
                //explode関数でそれぞれの値を取得
                $delData=explode("<>",$delCon[$i]);
                //削除番号と行番号が一致、パスワードがあっていれば削除
                if($delData[0]==$delete && $delData[4]==$passDel){
                array_splice($delCon,$i,1);
                file_put_contents($filename,implode($delCon));  
            }
        }
        }
        if(!empty($_POST["edit"])){
            $edit=$_POST["edit"];
            $filename="mission_3-5.txt";
            $editCon=file($filename);
            foreach($editCon as $line){
                $editData=explode("<>",$line);
                if($edit==$editData[0]){
                   $editnumber= $editData[0];
                   $editname=$editData[1];
                   $editcomment=$editData[2];
                }
            }
        }
        ?>
        
        <form action="" method="post">
        <input type="text" name="name" placeholder="名前" value="<?php if(isset($editname)) {echo $editname;} ?>"><br>
        <input type="text" name="comment" placeholder="コメント" value="<?php if(isset($editcomment)) {echo $editcomment;} ?>"><br>
        <input type="hidden" name="editNO" value="<?php if(isset($editnumber)) {echo $editnumber;} ?>">
        <input type="password" name="pass" placeholder="パスワード"　value="<?php if(isset($editpass)) {echo $editpass;} ?>">
        <input type="submit" name="submit" value="送信">
        </form>

        <form action="" method="post">
        <input type="text" name="deletenum" placeholder="削除番号"><br>
        <input type="password" name="passDel" placeholder="パスワード">
        <input type="submit" name="delete" value="削除">
        </form>

        <form action="" method="post">
        <input type="text" name="edit" placeholder="編集番号"><br>
        <input type="password" name="passEdi" placeholder="パスワード">
        <input type="submit" value="編集">
        </form>
        

        <?php
        //表示機能
        //ファイルの存在があるときだけ以下を行う
        if(file_exists($filename="mission_3-5.txt")){
            //読み込んだファイルを配列に格納
            $lines=file($filename,FILE_IGNORE_NEW_LINES);
            //取得したファイルデータをすべて表示（ループ処理）
            foreach($lines as $line){
                //explode関数でそれぞれの値を取得
                $word=explode("<>",$line);
                //取得した値を表示する
                echo $word[0]. " " .$word[1]. " " .$word[2]. " " .$word[3]. "<br>";
            }
        }
        ?>
    </body>
</html>