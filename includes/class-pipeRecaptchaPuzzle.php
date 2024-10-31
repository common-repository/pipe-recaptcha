<?php


class pipeRecaptchaPuzzle
{

    /**
     * classNormalPuzzle constructor.
     */
    public $prc;
    public function __construct($parent)
    {
        $this->prc = $parent;
    }

    public function thePuzzle($id=0)
    {
        global $wpdb;
        $puzzles = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}rc_pipe_recaptcha_puzzles WHERE id='{$id}'");
        $puzzlesArray = array();
        if (!empty($puzzles)) {
            foreach ($puzzles as $puzzle) {

                $puzzleItems = $puzzle->puzzle;
                $levelType   = $puzzle->level;
                $puzzleItems = explode('-', $puzzleItems);

                sort($puzzleItems);
                $row1 = $row2 = $row3 = $row4 = $row5 = $row6 = $row7 = array();
                foreach ($puzzleItems as $item) {
                    $row    = substr($item, 0, 1);
                    $col    = substr($item, 1, 1);
                    $pipe   = substr($item, 2, 1);
                    $rotate = substr($item, 3, 1);
                    $indicator = substr($item, 4, 1);

                    $colItem = array('pipe' => $pipe, 'rotate' => $rotate, 'pos' => $col);

                    if ($row == 1) {
                        if ($indicator=="i"){
                            $colItem['hidrant'] = 1;
                        }
                        $row1[] = $colItem;
                    }
                    if ($row == 2) {
                        $row2[] = $colItem;
                    }
                    if ($row == 3) {
                        $row3[] = $colItem;
                    }
                    if ($row == 4) {
                        $row4[] = $colItem;
                    }
                    if ($row == 5) {
                        $row5[] = $colItem;
                    }
                    if ($row == 6) {
                        $row6[] = $colItem;
                    }
                    if ($row == 7) {
                        if ($indicator=="i"){
                            $colItem['indicator'] = 1;
                        }
                        $row7[] = $colItem;
                    }
                }

                if (count($row1)==1){
                    $row1[0]['hidrant']=1;
                }
                if (count($row7)==1){
                    $row7[0]['indicator']=1;
                }

                $puzzlesArray =
                    array(
                        $this->prc->setPipe($row1, 1),
                        $this->prc->setPipe($row2, 2),
                        $this->prc->setPipe($row3, 3),
                        $this->prc->setPipe($row4, 4),
                        $this->prc->setPipe($row5, 5),
                        $this->prc->setPipe($row6, 6),
                        $this->prc->setPipe($row7, 7),
                    );

            }

        }

        return $puzzlesArray;
    }
}