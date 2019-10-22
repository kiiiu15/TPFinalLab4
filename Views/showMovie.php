<?php

//include(VIEWS. '/header.php');
?>

<div>

    <table >
        <thead>
            <td>Title </td>
            <td>Language</td>
            <td>Overview </td>
            <td>Release Date </td>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?php echo $movieToSearch->getTitle();?>
                </td>
                <td>
                    <?php echo $movieToSearch->getLanguage();?>
                </td>
                <td>
                    <?php echo $movieToSearch->getOverview();?>
                </td>
                <td>
                    <?php echo $movieToSearch->getReleaseDate();?>
                </td>
            </tr>
        </tbody>


    </table>



</div>