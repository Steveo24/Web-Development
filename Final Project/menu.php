<?

    if ($_SESSION['status'] == 'Admin'){ ?>
        
            <a href="index.php?page=addContact">Add Contact</a>&nbsp;&nbsp;&nbsp;
            <a href="index.php?page=deleteContact">Delete Contact</a>&nbsp;&nbsp;&nbsp;
            <a href="index.php?page=addAdmin">Add Admin</a>&nbsp;&nbsp;&nbsp;
            <a href="index.php?page=deleteAdmin">Delete Admin</a>&nbsp;&nbsp;&nbsp;
            <a href="index.php?page=logout">Log Out</a>
        
        <?} else { ?>
        
                <a href="index.php?page=addContact">Add Contact</a>&nbsp;&nbsp;&nbsp;
                <a href="index.php?page=deleteContact">Delete Contact</a>&nbsp;&nbsp;&nbsp;
                <a href="index.php?page=logout">Log Out</a>

            <?
        }
                ?>