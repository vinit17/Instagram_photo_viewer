<?php
/**
* Created by PhpStorm.
* User: Vinit
* Date: 9/30/2017
* Time: 1:18 AM
*/
?>
<html>
<head>
    <title>
        Insta Photo Album
    </title>
    <h1>Instagram Media Page</h1><br><br>
</head>

<?php

//Getting username from the user as input:
echo "<body align=center>Enter the username <br><br>
    <form method='GET' align = center>
    UserName:
    <input type='text' name='username' placeholder='Username'><br><br>
   <button type = 'submit'>Submit</button>
   </form></body>";
?>
--------------------------------------------------------------------------------------------------------------------------------------------------<br>
<?php

    // Validating user input and decoding json data:
   if(isset($_GET['username']))
   {
   $username = $_GET['username'];
   $file = file_get_contents("https://www.instagram.com/".$username."/media/");
   $json = json_decode($file);

   //Click on the image to redirect it to it's instagram.com page:
       foreach ($json->items as $item){
           $img = $item->user->profile_picture;
           echo "<a href='https://www.instagram.com/".$username."'>";
           echo "<img src = '".$item->user->profile_picture."'></a>";
           break;
       }

        echo "<div align = center>";
        foreach ($json->items as $item){
        print $item->user->full_name;
        break;
        }

       echo "</div><br><br>";

       //Determining locations of posts:

       echo"Displaying the recent 3 posts with their locations:<br>";
       $count = 1;
       echo "<table align='center'>";
       foreach ($json->items as $item){
               if ($count <= 3) {
                   echo "<tr><td>" . $count . ". </td>";
                   if($item->location!=null && $item->location->name != null){
                   echo "<td>" . $item->location->name . "</td>";
                   }else{
                       echo "<td>Location Not Specified</td>";
                   }
                   echo "<td><img src = '" . $item->images->thumbnail->url . "' height = 75px width = 75px></td>";
                   $count += 1;
                   echo "</tr>";
               }
       }
       echo "</table>";


       //Calculating average number of likes per post

       $total_likes = 0; $count_of_likes = 0;
       foreach ($json->items as $item){
           $total_likes += $item->likes->count;
           $count_of_likes += 1;
       }

       echo"<br>Total number of likes:"; echo $total_likes;
       echo "<br>Number of posts liked: "; echo $count_of_likes;
       if($total_likes!=0||$count_of_likes!=0)
       {
           echo "<br><b>Average likes per post = ";
           echo round(($total_likes / $count_of_likes), 0);
           echo"</b><br>";
       }
       else{
           echo "<br><b>Average likes per post:0 </b><br>";
       }


       // Calculating average number of comments per post

       $total_comments = 0; $count_of_comments = 0;
       foreach ($json->items as $item){
               $total_comments += $item->comments->count;
               $count_of_comments += 1;
        }

       echo"<br>Total number of comments:"; echo $total_comments;
       echo "<br>Number of posts commented on: "; echo $count_of_comments;
       if($total_comments!=0||$count_of_comments!=0)
       {
           echo "<br><b>Average comments per post = ";
           echo round(($total_comments / $count_of_comments), 0);
           echo "</b><br>";
       }
       else{
           echo "<br><b>Average comments per post:0 </b>";
       }
}
?>
</html>