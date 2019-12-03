<?php

function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = [
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    ];
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k.' '.$v.($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) {
        $string = array_slice($string, 0, 1);
    }

    return $string ? implode(', ', $string).' ago' : 'just now';
}

function ActivityLog($con, $detail, $id, $type = 0)
{
    $addtime = time();
    $in = mysqli_query($con, "INSERT INTO activities(adetail,addDate,userID,type) VALUES('$detail','$addtime','$id','$type')");
}
function ProjectLog($con, $detail, $id, $userid)
{
    $addtime = time();
    $ino = mysqli_query($con, "INSERT INTO projectlog(detail,addDate,projectID,managerID) VALUES('$detail','$addtime','$id','$userid')");
}

    function SendMail($from, $subject, $to, $message, $fromname = '', $toname = '')
    {
        require 'phpmail/PHPMailerAutoload.php';
        $mail = new PHPMailer();

        try {
            $mail->setFrom($from, $fromname);
            $mail->addAddress($to, $toname);
            $mail->addReplyTo($from, 'NoReply');
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->send();
            $error = ' Message sent';
        } catch (Exception $e) {
            $error .= 'Error: Message could not be sent to '.$to;
            $error .= '<br>Mailer Error: '.$mail->ErrorInfo;
        }

        return $error;
    }

    function pagination($con, $page_id, $query, $ppage = 20)
    {
        global $pagination,$page,$lastpage;
        $adjacents = 3;

        /*
           First get total number of rows in data table.
           If you have a WHERE clause in your query, make sure you mirror it here.
        */
        $wweck = mysqli_query($con, $query);  //update current user time left
        $total_pages = mysqli_num_rows($wweck);

        /* Setup vars for query. */
        $targetpage = $page_id; 	//your file name  (the name of this file)
    $limit = $ppage; 								//how many items to show per page
    $page = isset($_GET['page']) ? $_GET['page'] : 0;
        if ($page) {
            $start = ($page - 1) * $limit;
        } 			//first item to display on this page
        else {
            $start = 0;
        }								//if no page var is given, set start to 0

        /* Get data. */
        $result = mysqli_query($con, $query." LIMIT $start, $limit");

        /* Setup page vars for display. */
        if ($page == 0) {
            $page = 1;
        }					//if no page var is given, default to 1.
    $prev = $page - 1;							//previous page is page - 1
    $next = $page + 1;							//next page is page + 1
    $lastpage = ceil($total_pages / $limit);		//lastpage is = total pages / items per page, rounded up.
    $lpm1 = $lastpage - 1;						//last page minus 1

    /*
        Now we apply our rules and draw the pagination object.
        We're actually saving the code to a variable in case we want to draw it more than once.
    */
        $pagination = '';
        if ($lastpage > 1) {
            $pagination .= '<div class="pagination">';
            //previous button
            if ($page > 1) {
                $pagination .= "<a href=\"$targetpage?page=$prev\">< previous</a>";
            } else {
                $pagination .= '<span class="disabled">< previous</span>';
            }

            //pages
        if ($lastpage < 7 + ($adjacents * 2)) {	//not enough pages to bother breaking it up
            for ($counter = 1; $counter <= $lastpage; $counter++) {
                if ($counter == $page) {
                    $pagination .= "<span class=\"current\">$counter</span>";
                } else {
                    $pagination .= "<a href=\"$targetpage?page=$counter\">$counter</a>";
                }
            }
        } elseif ($lastpage > 5 + ($adjacents * 2)) {	//enough pages to hide some
            //close to beginning; only hide later pages
            if ($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<span class=\"current\">$counter</span>";
                    } else {
                        $pagination .= "<a href=\"$targetpage?page=$counter\">$counter</a>";
                    }
                }
                $pagination .= '...';
                $pagination .= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
                $pagination .= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";
            }
            //in middle; hide some front and some back
            elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                $pagination .= "<a href=\"$targetpage?page=1\">1</a>";
                $pagination .= "<a href=\"$targetpage?page=2\">2</a>";
                $pagination .= '...';
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<span class=\"current\">$counter</span>";
                    } else {
                        $pagination .= "<a href=\"$targetpage?page=$counter\">$counter</a>";
                    }
                }
                $pagination .= '...';
                $pagination .= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
                $pagination .= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";
            }
            //close to end; only hide early pages
            else {
                $pagination .= "<a href=\"$targetpage?page=1\">1</a>";
                $pagination .= "<a href=\"$targetpage?page=2\">2</a>";
                $pagination .= '...';
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<span class=\"current\">$counter</span>";
                    } else {
                        $pagination .= "<a href=\"$targetpage?page=$counter\">$counter</a>";
                    }
                }
            }
        }

            //next button
            if ($page < $counter - 1) {
                $pagination .= "<a href=\"$targetpage?page=$next\">next ></a>";
            } else {
                $pagination .= '<span class="disabled">next ></span>';
            }
            $pagination .= "</div>\n";
        }

        return $result;
    }
