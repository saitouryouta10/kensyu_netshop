<?php
/**
 * データベース操作クラス
 */

require_once(dirname(__FILE__, 3) . '/config/db.php');

class DBController
{
    /**
     * mysqliインスタンス
     *
     * @var mysqli
     */


    protected $dbh = null;


    /**
     * 実行結果形式(MYSQLI_ASSOC: カラム名をキーにした連想配列)
     *
     * @var int
     */


    protected $fetch_mode = MYSQLI_ASSOC;



    /**
     * SQL実行結果の取得形式
     *
     * @param int $mode
     * @return void
     */
    public function setFetchMode($mode)
    {
        $this->fetch_mode = $mode;
    }

    /**
     * コンストラクタ


     * 

     *

     * @return DBController
     */
    function __construct()
    {
        // エラー報告モード設定
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        // DB接続
        $this->doConnect();
    }

    /**
     * データベース接続
     *
     * @return void
     */
    function doConnect()
    {
        try {
            // DB接続
            $this->dbh = new mysqli(HOST, USER, PASS, DBName);
        } catch (mysqli_sql_exception $e) {
            // TODO: エラー処理
            echo $e->getMessage();
            exit;
        }
    }

    /**
     * SQLを実行し、取得したデータを$fetch_mode形式で返す
     * 　データが0件の場合空配列、実行に失敗した場合falseを返す
     *
     * @param string $sql
     * @param string $types
     * @param mixed ...$vars
     * @return mixed
     */
    function executeQuery($sql, $types = null, ...$vars)
    {
        $data = [];

        try {
            // 実行準備
            $stmt = $this->dbh->prepare($sql);



            // 変数を使用する場合バインド
            if ($types && $vars) {
                $vars = (array)$vars;

                $stmt->bind_param($types, ...$vars);
            }

            // 実行
            $stmt->execute();

            // 結果を取得
            $result = $stmt->get_result();
            while ($row = $result->fetch_array($this->fetch_mode)) {
                $data[] = $row;
            }
        } catch (mysqli_sql_exception $e) {
            // echo $e->getMessage();
            $data = false;
        }

        // NOTE: 実行元でfalseチェックしてエラー処理を実装する
        return $data;
    }

    // TODO: 削除関数


    // TODO: 登録関数
    /**
     * SQLを実行し、インサートする
     * 　成功した場合true　失敗した場合falseを返す
     *
     * @param string $sql
     * @param string $types
     * @param mixed ...$vars
     * @return boolean
     */

    function executeInsert($sql,$types = null, ...$vars)

    {
        $data = true;

        try {

            $stmt = $this->dbh->prepare($sql);

            if($types && $vars) {


                $stmt->bind_param($types, ...$vars);
            }

            $stmt->execute();


        } catch (mysqli_sql_exception $e) {
            $data = false;
        }

        return $data;
    }


    // TODO: 更新関数

    function executeUpdate($sql,$types = null, ...$vars)
    {
        $data = true;

        try {

            $stmt = $this->dbh->prepare($sql);

            if($types && $vars) {
                $stmt->bind_param($types, ...$vars);
            }

            $stmt->execute();

        } catch (mysqli_sql_exception $e) {
            $data = false;
        }

        return $data;
    }

}