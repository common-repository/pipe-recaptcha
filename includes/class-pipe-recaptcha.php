<?php

/**
 * Class pipeRecaptcha
 */
require 'class-pipeRecaptchaPuzzle.php';

class pipeRecaptcha{
    /**
     * @var column
     * @since 1.0.0
     */
    private $column;


    /**
     * @var row
     */
    private $row;

    /**
     * @var level
     */
    private $level;

    private $rand1;
    private $rand2;
    private $rand3;

    /**
     * pipeRecaptcha constructor.
     */

    public $puzzleKey;

    public $puzzles;
    public function __construct($level='normal')
    {
        /*if ($lvl=="1"){
            $level = "normal";
        }
        else{
            $r = rand(1,3);
            if ($r==1){
                $level = "normal";
            }
            if ($r==2){
                $level = "medium";
            }
            if ($r==3){
                $level = "hard";
            }
        }*/
        $this->level= $level;
        $this->rand1 = rand(1, 7);
        $this->rand2 = $this->getRand($this->rand1);
        $this->rand3 = $this->getLevel()=="hard" ? $this->getRand(array($this->rand1, $this->rand2)): 0;
        $this->column = 6;
        $this->row = 8;
        $this->puzzles = new pipeRecaptchaPuzzle($this);
    }

    public function getRand($exclude)
    {
        if (is_array($exclude)){
            $arr = $exclude;
        }
        else{
            $arr = array($exclude);
        }
        do {
            $n = rand(1,7);

        } while(
            in_array($n, $arr)
        );
        return $n;
    }

    /**
     * @return int
     */
    public function getRand1()
    {
        return $this->rand1;
    }

    /**
     * @return int
     */
    public function getRand2()
    {
        return $this->rand2;
    }
    /**
     * @return int
     */
    public function getRand3()
    {
        return $this->rand3;
    }


    public function getCaptchaRow($rows=array(), $i=0)
    {

        $imageName = "";
        $colNum = 1;
        $html = '<div class="rc-pipe-recaptcha-row">';
        if (!empty($rows)){
            foreach ($rows as $row) {
                $pipe = isset($row['pipe']) ? $row['pipe']: 1;
                $rotate = isset($row['rotate']) ? $row['rotate']: 4;

                if ($pipe == 2){
                    if ($rotate == 1 || $rotate == 3){
                        $rotate = 1;
                    }
                    else{
                        $rotate = 2;
                    }
                }

                if ($pipe == '1'){
                    $imageName = 'transparent';
                }
                elseif ($pipe == '2'){
                    $imageName = 'pipe';
                }
                elseif ($pipe == '3'){
                    $imageName = 'elbow';
                }
                elseif ($pipe == '4'){
                    $imageName = 'T';
                }
                if ($i==1&&isset($row['hidrant'])&&$row['hidrant']==1){
                    $html .= '<div class="rc-pipe-recaptcha-col" data-col="'.$colNum.'" data-pipe="'.$pipe.'" data-rotate="'.$rotate.'" data-row="'.$i.'"><div class="pipe-recaptcha-element"><img src="'. PR_Plugin_DIR_URL .'/assets/images/fire-hidrant.png" alt="" class="pipe-recaptcha-image fire-hidrant"><img src="'. PR_Plugin_DIR_URL .'/assets/images/'.$imageName.'.png" alt="" class="pipe-recaptcha-image rotate-'.$rotate.'"></div></div>';

                }
                elseif ($i==($this->row)-1&&isset($row['indicator'])&&$row['indicator']==1){
                    $html .= '<div class="rc-pipe-recaptcha-col" data-col="'.$colNum.'" data-pipe="'.$pipe.'" data-rotate="'.$rotate.'" data-row="'.$i.'"><div class="pipe-recaptcha-element"><img src="'. PR_Plugin_DIR_URL .'/assets/images/'.$imageName.'.png" alt="" class="pipe-recaptcha-image rotate-'.$rotate.'"><img src="'. PR_Plugin_DIR_URL .'/assets/images/indicator.png" alt="" class="pipe-recaptcha-image indicator"></div></div>';

                }else{
                    $html .= '<div class="rc-pipe-recaptcha-col" data-col="'.$colNum.'" data-pipe="'.$pipe.'" data-rotate="'.$rotate.'" data-row="'.$i.'"><div class="pipe-recaptcha-element"><img src="'. PR_Plugin_DIR_URL .'/assets/images/'.$imageName.'.png" alt="" class="pipe-recaptcha-image rotate-'.$rotate.'"></div></div>';
                }
                $colNum++;
            }
        }
        $html .= '</div>';

        return $html;
    }

    /**
     * @return mixed
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @param mixed $column
     */
    public function setColumn($column)
    {
        $this->column = $column;
    }

    public function getPuzzles($id)
    {
        return $this->puzzles->thePuzzle($id);
    }

    public function setPipe($pipes=array(), $row=0)
    {
        $col = $this->getColumn();

        $cols = array();
        for ($i=1; $i<=$col; $i++){
            if ($pipe = $this->isPipePositionSet($pipes, $i)){
                $cols[] = $pipe;
            }
            else{
                $cols[] = array(
                    'pipe' => 1,
                    'rotate' => 1
                );
            }
        }

        if ($this->getRand1()==$row||$this->getRand2()==$row||$this->getRand3()==$row){
            $cols = $this->getRandomChallenge($cols);
        }
        return $cols;
    }

    public function getRandomChallenge($cols)
    {
        $activeColumns = $this->getColumnPosition($cols);

        if (count($activeColumns)>1){
            $rand = rand(1, (count($activeColumns)-1));
            $rand2 = rand(1, 2);
            if ($cols[$activeColumns[0]]['pipe']==2){
                if($cols[$activeColumns[0]]['rotate']==3){
                    $rotate = 1;
                }
                elseif($cols[$activeColumns[0]]['rotate']==4){
                    $rotate = 2;
                }
                else{
                    $rotate = $cols[$activeColumns[0]]['rotate'];
                }
                $cols[$activeColumns[0]]['rotate'] = $this->getRotate(array($rotate, 3, 4));
                if ($rand2==2){
                    $cols[$activeColumns[$rand]]['rotate'] = $this->getRotate(array($rotate, 3, 4));
                }
            }
            else{
                $cols[$activeColumns[0]]['rotate'] = $this->getRotate($cols[$activeColumns[0]]['rotate']);
                if ($rand2==2){
                    $cols[$activeColumns[$rand]]['rotate'] = $this->getRotate($cols[$activeColumns[0]]['rotate']);
                }
            }
        }
        else{
            if($cols[$activeColumns[0]]['rotate']==3){
                $rotate = 1;
            }
            elseif($cols[$activeColumns[0]]['rotate']==4){
                $rotate = 2;
            }
            else{
                $rotate = $cols[$activeColumns[0]]['rotate'];
            }
            $cols[$activeColumns[0]]['rotate'] = $this->getRotate(array($rotate, 3, 4));
        }

        return $cols;
    }

    public function getColumnPosition($cols)
    {
        $t= array();
        $i=0;
        foreach ($cols as $col) {
            if (isset($col['pos'])){
                $t[] = $i;
            }
            $i++;
        }
        shuffle($t);
        return $t;
    }

    public function isPipePositionSet($pipes = array(), $pos)
    {
        if(!empty($pipes)){
            foreach ($pipes as $pipe) {
                if (isset($pipe['pos']) && $pipe['pos'] == $pos){
                    return $pipe;
                    break;
                }
            }
        }
        return false;
    }

    public function getPuzzle($id=0)
    {
        return $this->puzzles->thePuzzle($id);
    }

    public function getRotate($exclude)
    {
        if (is_array($exclude)) {
            $arr = $exclude;
        }
        else{
            $arr = array($exclude);
        }
        do {
            $n = rand(1,4);

        } while(
            in_array($n, $arr)
        );
        return $n;

    }

    public function getRecaptcha()
    {
        $i=1;
        $puzzle = array();

        if ($this->level == 'normal'){
            $id = $this->getRandomNormalPuzzleId();
            $puzzle = $this->getPuzzle($id);
            $this->setPuzzleKey($id);
        }
        if ($this->level == 'medium'){
            $id = $this->getRandomMediumPuzzleId();
            $puzzle = $this->getPuzzle($id);
            $this->setPuzzleKey($id);
        }
        if ($this->level == 'hard'){
            $id = $this->getRandomHardPuzzleId();
            $puzzle = $this->getPuzzle($id);
            $this->setPuzzleKey($id);
        }
        $html ="";
        if (!empty($puzzle)){
            foreach ($puzzle as $item) {
                $html .= $this->getCaptchaRow($item, $i);
                $i++;
            }

           return $html;
        }

    }

    public function getRandomNormalPuzzleId()
    {
        global $wpdb;
        $total = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}rc_pipe_recaptcha_puzzles WHERE level='1'");
        $rand = rand(0, ($total-1));
        $puzzles = $wpdb->get_results("SELECT id FROM {$wpdb->prefix}rc_pipe_recaptcha_puzzles WHERE level='1' LIMIT 1 OFFSET $rand");

        if (isset($puzzles[0])) {
            return $puzzles[0]->id;
        } else {
            $this->getRandomNormalPuzzleId();
        }
    }
    public function getRandomMediumPuzzleId()
    {
        global $wpdb;
        $total = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}rc_pipe_recaptcha_puzzles WHERE level='2'");
        $rand = rand(0, ($total-1));
        $puzzles = $wpdb->get_results("SELECT id FROM {$wpdb->prefix}rc_pipe_recaptcha_puzzles WHERE level='2' LIMIT 1 OFFSET $rand");

        if (isset($puzzles[0])) {
            return $puzzles[0]->id;
        } else {
            $this->getRandomMediumPuzzleId();
        }
    }
    public function getRandomHardPuzzleId()
    {
        global $wpdb;
        $total = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}rc_pipe_recaptcha_puzzles WHERE level='3'");
        $rand = rand(0, ($total-1));
        $puzzles = $wpdb->get_results("SELECT id FROM {$wpdb->prefix}rc_pipe_recaptcha_puzzles WHERE level='3' LIMIT 1 OFFSET $rand");

        if (isset($puzzles[0])) {
            return $puzzles[0]->id;
        } else {
            $this->getRandomHardPuzzleId();
        }
    }

    public function setCookie()
    {
       $userId = $this->RandomString();
       if (isset($_COOKIE['prcuagid'])){
           $userId = sanitize_text_field($_COOKIE['prcuagid']);
       }
       else{
           setcookie('prcuagid', $userId, time() + (86400 * 30), "/");
       }
       return $userId;
    }
    public function getCookie()
    {
        if (isset($_COOKIE['prcuagid'])){
            return sanitize_text_field($_COOKIE['prcuagid']);
        }
        else{
            return $this->setCookie();
        }
    }
    public function RandomString($limit=10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < $limit; $i++) {

            $randstring .= substr($characters, rand(0, strlen($characters)), 1);
        }
        return $randstring;
    }
    public function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    /**
     * @param mixed $puzzleKey
     */
    public function setPuzzleKey($puzzleId)
    {
        global $wpdb;
        $puzzle = $wpdb->get_results("SELECT puzzle_key FROM {$wpdb->prefix}rc_pipe_recaptcha_puzzles WHERE id='$puzzleId' ");
        if (!empty($puzzle)){
            $this->puzzleKey = isset($puzzle[0]->puzzle_key)?$puzzle[0]->puzzle_key:"";
        }

    }

    /**
     * @return mixed
     */
    public function getPuzzleKey()
    {
        return $this->puzzleKey;
    }

    /**
     * @return level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param level $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }


}
