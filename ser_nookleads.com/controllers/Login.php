<?php
class Login extends BaseController {
    private $para, $loginMod;
    function __construct($para = false) {
        parent::__construct();
        $this->para = $para;
        if (!$para) {
            $this->loginMod = new Login_Model();
            $this->loginMod->setLeadData($this->postPara);
        }
    }
    public function Index() {
        $this->baseview->setHeader('commonHeader.php');
        $this->baseview->setBody('Login');
        $this->baseview->setFooter('Footer.php');
        $this->baseview->RenderView(true);
    }
    public function signIn() {
        $this->baseview->setjsonData($this->loginMod->signIn());
        echo $this->baseview->renderJson();
    }
    public function forgotPassword($param) {
        $this->loginMod->forgotPassword();
        if (isset($_SESSION["PASSWD"]["logindata"])) {
            $message = '<table width="80%" border="0" align="center" cellpadding="3" cellspacing="3">
                <td align="center"><p><span style="font-weight:900; font-size:24px;  color:#999;">nOOkLeads Account details.</span></p></td>
                <td colspan="2">&nbsp;</td>
                <tr>
                <td width="50%" align="left">Name : ' . $_SESSION["PASSWD"]["logindata"]["user_name"] . '</td>
                </tr>
                <tr>
                <td width="50%" align="left">Email id : ' . $_SESSION["PASSWD"]["logindata"]["email"] . '</td>
                </tr>
                <tr>
                <td width="50%" align="left">Password : ' . $_SESSION["PASSWD"]["logindata"]["password"] . '</td>
                </tr>
                <tr>
                <td colspan="2"><p>You received this email because you are the user of nookleads.</p></td>
                </tr>
                <tr>
                <td colspan="2">Regards,<br />nOOkLeads</td>
                </tr>
                <tr>
                <td colspan="2"><p><h4>Do not reply to this mail.</h4></p></td>
                </tr>
                </table>';
            $this->baseview->setjsonData($this->sendMail(array(
                        "to" => $_SESSION["PASSWD"]["logindata"]["email"],
                        "title" => 'Request password - ' . $_SESSION["PASSWD"]["logindata"]["user_name"],
                        "subject" => 'Password Requested from :- ' . $_SESSION["PASSWD"]["logindata"]["email"],
                        "message" => $message,
            )));
            echo $this->baseview->renderJson();
        }
    }
}
?>