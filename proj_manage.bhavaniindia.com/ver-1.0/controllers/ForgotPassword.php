<?php
class ForgotPassword extends BaseController {

    private $para, $loginMod;

    public function __construct($para = false) {
        parent::__construct();
        $this->gotoDashboard();
        $this->para = $para;
        $this->loginMod = new Login_Model();
        $this->loginMod->setPostData($this->postPara);
    }
    public function Index() {
        $this->baseview->title = 'Forgot password';
        $this->baseview->setHeader('IndexHeader.php');
        $this->baseview->setBody('ForgotPassword');
        $this->baseview->setFooter(NULL);
        $this->baseview->RenderView(true);
    }
    public function forgotPassword($param) {
        $this->loginMod->forgotPassword();
        if (isset($_SESSION["PASSWD"]["logindata"])) {
            $message = '<table width="80%" border="0" align="center" cellpadding="3" cellspacing="3">
                <td align="center"><p><span style="font-weight:900; font-size:24px;  color:#999;">Local Talent Account details.</span></p></td>
                <td colspan="2">&nbsp;</td>
                <tr>
                <td width="50%" align="left">Name : ' . $_SESSION["PASSWD"]["logindata"]["user_name"] . '</td>
                </tr>
                <tr>
                <td width="50%" align="left">Email id : ' . $_SESSION["PASSWD"]["logindata"]["user_email"] . '</td>
                </tr>
                <tr>
                <td width="50%" align="left">Password : ' . $_SESSION["PASSWD"]["logindata"]["user_password"] . '</td>
                </tr>
                <tr>
                <td colspan="2"><p>You received this email because you are the user of Local Talent.</p></td>
                </tr>
                <tr>
                <td colspan="2">Regards,<br />Local Talent</td>
                </tr>
                <tr>
                <td colspan="2"><p><h4>Do not reply to this mail.</h4></p></td>
                </tr>
                </table>';
            $this->baseview->setjsonData($this->sendMail(array(
                        "to" => $_SESSION["PASSWD"]["logindata"]["user_email"],
                        "title" => 'Request password - ' . $_SESSION["PASSWD"]["logindata"]["user_name"],
                        "subject" => 'Password Requested from :- ' . $_SESSION["PASSWD"]["logindata"]["user_email"],
                        "message" => $message,
            )));
            echo $this->baseview->renderJson();
        }
    }
}
?>