<?php

class UserDBController extends DBController
{

    /**
     * 登録しようとしているメールアドレスが
     * 既に登録されているものかどうかを見る
     *
     * @param string $form 
     * @return string $match_error
     */
    function userExecuteQuery($form) 
    {

        $match_error = null;
        $data_are = null;

        $sql = "SELECT email FROM users";
        $data_are = parent::executeQuery($sql,"");

        if (!$data_are) {
            exit();
        } else {
            foreach ($data_are as $data){
    
                if ($form === $data["email"]){
    
                    $match_error = "dup";
                }
            }
        }

        return $match_error;
    }

     /**
     * 新規会員登録
     * 成功すればtrue失敗すればfalse
     *
     * @param string $form 
     * @return bool $bool
     */
    function userInsertQuery($form) 
    {
        $password = password_hash($form["pass"],PASSWORD_DEFAULT);

        $sql = "insert into users(name,name_kana,nickname,sex,birthday,zipcode,address,tell,email,pass)
                VALUES(?,?,?,?,?,?,?,?,?,?)";

        $types = "sssissssss";

        $bool = parent::insertQuery($sql,$types,$form["name"],$form["name_kana"],$form["nickname"],$form["sex"],$form["birthday"],$form["zipcode"],
                                    $form["address"],$form["tell"],$form["email"],$password);

        return $bool;
    }


    
}
