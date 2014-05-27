<?php
setcookie(
            'username',
            '',
            time() - (365 * 24 * 60 * 60),
            '/'
        );

setcookie(
            'remember',
            '',
            time() - (365 * 24 * 60 * 60),
            '/'
        );
?>