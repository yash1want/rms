<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php header("Content-Security-Policy: script-src 'self' 'unsafe-inline' 'unsafe-eval'; report-uri /ibm_csp_report_parser;"); ?>
    <?php header('X-Frame-Options: SAMEORIGIN'); ?>
    <title>Indian Bureau of Mines</title>
    <link rel="shortcut icon" href="/favicon.ico" />
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="/ReturnsAudit/css/style.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/ReturnsAudit/css/admin-menu.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/ReturnsAudit/css/slidedown-menu2.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/ReturnsAudit/css/jquery.ui.all.css" />
    <script type="text/javascript" src="/ReturnsAudit/js/swfobject.js"></script>
    <script type="text/javascript" src="/ReturnsAudit/js/slidedown-menu2.js"></script>
    <script type="text/javascript" src="/ReturnsAudit/js/AC_RunActiveContent.js"></script>
    <script type="text/javascript" src="/ReturnsAudit/js/jquery.min.js"></script>
    <script type="text/javascript" src="/ReturnsAudit/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/ReturnsAudit/js/ie-check.js"></script>
    <script type="text/javascript" src="/ReturnsAudit/js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="/ReturnsAudit/js/formF1_validation.js"></script> -->

</head>
<body>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <?php echo $this->fetch('content'); ?>
        <?php //echo $this->element('print_footer'); ?>
    </table>

</body>
</html>
