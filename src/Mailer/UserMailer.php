<?php
namespace App\Mailer;
use Cake\Mailer\Mailer;
class UserMailer extends Mailer
{

public function send_email($fileUrl = null,$client_name = null,$reportDate = null) // all users
{	
	// $user = 'taylor.gagnon@baesystems.com';
	$user = 'richard.f.howard@baesystems.com';
	//$user = 'arundhati.lambore@canqualify.com';
    $toMail = $user;
    if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
        $toMail = 'arundhati.lambore@canqualify.com';
    }    
	$this->setTransport('aws_smtp')
	->setFrom(['no-reply@canqualify.com' => 'CanQualify Info'])
	->setBcc(CC_EMAIL)
	->setReplyTo('aaron@canqualify.com')
	->setTo($toMail)
	->setEmailFormat('html')
	->setSubject(sprintf('Employee Orientation Status Report('.$reportDate.')'))
	//->setSubject(sprintf('Welcome %s', $user))
	->setAttachments ($fileUrl)
	->setViewVars([
		'useremail'=> $user,
		'client_name'=> $client_name,
		'reportDate'=>$reportDate

	])
	->viewBuilder()->setTemplate('send_email');
}

public function register($user) // all users
{
    $toMail = $user->username;
    if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
        $toMail = 'arundhati.lambore@canqualify.com';
    }
	$this->setTransport('aws_smtp')
	->setFrom(['no-reply@canqualify.com' => 'CanQualify Info'])
	->setBcc(CC_EMAIL)
	->setReplyTo('aaron@canqualify.com')
	->setTo($toMail)
	->setEmailFormat('html')
	->setSubject('Welcome to CanQualify')
	->setViewVars([
		'useremail'=> $user->username
	])
	->viewBuilder()->setTemplate('register');
}

public function register_contractor($user) // New Contractor register
{
    $toMail = 'aaron@canqualify.com';
    if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
        $toMail = 'arundhati.lambore@canqualify.com';
    }
	$this->setTransport('aws_smtp')
	->setFrom(['no-reply@canqualify.com' => 'CanQualify Info'])
	->setBcc(CC_EMAIL)
	->setTo($toMail)
	->setEmailFormat('html')
	->setSubject(sprintf('Welcome %s', $user->username))
	->setViewVars([
		'useremail'=> $user->username
	])
	->viewBuilder()->setTemplate('register');
}

public function register_approve($user, $user_details=array(), $cr_emails=array()) // all users
{
	$cc_emails = CC_EMAIL;
    $toMail = $user->username;
    if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
        $toMail = 'arundhati.lambore@canqualify.com';
    }
    else { // if production
    if(!empty($cr_emails)){
		$cc_emails = array_merge($cc_emails, $cr_emails);
	}
	else{$cr_emails = array();}
    }
	$this->setTransport('aws_smtp')
	->setFrom(['no-reply@canqualify.com' => 'CanQualify Info'])
	->setCc($cr_emails)
	->setBcc($cc_emails)
	->setReplyTo('aaron@canqualify.com')
	->setTo($toMail)    
	->setEmailFormat('html')   
	->setSubject(sprintf('Complete Your Registration'))
	->setViewVars([
		'useremail'=> $user->username,
		'name'=> !empty($user_details) ? $user_details['pri_contact_fn'].', '.$user_details['company_name'] : $user->username
	])
	->viewBuilder()->setTemplate('register_approve');
}


public function resetpassword($user)
{
	// attach a text file
	/*$this->setAttachments([ 	// attach an image file
	'edit.png'=>[ 
		'file'=>'files/welcome.png',
		'mimetype'=>'image/png',
		'contentId'=>'734h3r38'
	]
	])*/
    $toMail = $user->username;
    if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
        $toMail = 'arundhati.lambore@canqualify.com';
    }
	$this->setTransport('aws_smtp')
	->setFrom(['no-reply@canqualify.com' => 'CanQualify Info'])
	->setBcc(CC_EMAIL)
	->setReplyTo('aaron@canqualify.com')
	->setTo($toMail) // add email recipient    
	->setEmailFormat('html') // email format
	->setSubject(sprintf('Reset password %s', $user->username)) // subject of email
	->setViewVars([ // these variables will be passed to email template defined in step 5 with name registered.ctp
		'useremail'=> $user->username,
		'reseturl'=> $user->reset_url
	]) 
	// the template file you will use in this email
	->viewBuilder()->setTemplate('resetpassword'); // By default template with same name as method name is used.
}


public function register_cr($cr) // register cr
{
	 
    $toMail = $cr->user->username;
    if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
        $toMail = 'arundhati.lambore@canqualify.com';
    }
	$this->setTransport('aws_smtp')
	->setFrom(['no-reply@canqualify.com' => 'CanQualify Info'])
	->setBcc(CC_EMAIL)
	->setReplyTo('aaron@canqualify.com')
	->setTo($toMail)
	->setEmailFormat('html')
	->setSubject(sprintf('Welcome %s', $cr->user->username))
	->setViewVars([
		'full_name'=> $cr->pri_contact_fn." ".$cr->pri_contact_ln,
		'reseturl'=> $cr->reset_url
	])
	->viewBuilder()->setTemplate('register_cr');
}

public function register_employee($employee,$company_name) // register employee
{
    $toMail = $employee->user->username;
    if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
        $toMail = 'arundhati.lambore@canqualify.com';
    }
	$this->setTransport('aws_smtp')
	->setFrom(['no-reply@canqualify.com' => 'CanQualify Info'])
	->setBcc(CC_EMAIL)
	->setReplyTo('aaron@canqualify.com')
	->setTo($toMail)
	->setEmailFormat('html')
	->setSubject(sprintf('Welcome %s', $employee->user->username))
	->setViewVars([
		'full_name'=> $employee->pri_contact_fn.' '.$employee->pri_contact_ln,
		'company_name'=> $company_name,
		'reseturl'=> $employee->reset_url
	])
	->viewBuilder()->setTemplate('register_employee');
}

public function save_employee($employee,$company_name) // register employee
{
     $toMail = 'aaron@canqualify.com';
    if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
        $toMail = 'arundhati.lambore@canqualify.com';
    }
	$this->setTransport('aws_smtp')
	->setFrom(['no-reply@canqualify.com' => 'CanQualify Info'])
	->setBcc(CC_EMAIL)
	->setReplyTo('aaron@canqualify.com')
	->setTo($toMail)
	->setEmailFormat('html')
	->setSubject(sprintf('Welcome %s', $employee->username))
	->setViewVars([
		'employee'=> $employee,
		'company_name'=> $company_name
	])
	->viewBuilder()->setTemplate('save_employee');
}
public function send_request($contractor, $mailInfo,$client) // Send Request to Contractor
{

    $toMail = $contractor->user->username;
	$name=$contractor->pri_contact_fn .$contractor->pri_contact_ln;
	$name_company=$client->company_name;
    if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
        $toMail = 'arundhati.lambore@canqualify.com';
    }

	$mail_result = $this->setTransport('aws_smtp')
	->setFrom(['no-reply@canqualify.com' => 'CanQualify Info'])
	->setBcc(CC_EMAIL)
	->setReplyTo('aaron@canqualify.com')
	->setTo($toMail)
	->setEmailFormat('html')
	->setSubject($mailInfo['subject'])
	->setViewVars([
		'contractor'=> $contractor,
		'mailInfo'=> $mailInfo,
		'client' => $client
	])
	->viewBuilder()->setTemplate('send_client_request');
}
public function send_request_admin($mailInfo) // register cr
{
    $toMail = 'aaron@canqualify.com';
    if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
        $toMail = 'arundhati.lambore@canqualify.com';
    }
	$this->setTransport('aws_smtp')
	->setFrom(['no-reply@canqualify.com' => 'CanQualify Info'])
	->setReplyTo('aaron@canqualify.com')
	->setBcc(CC_EMAIL)
	->setTo($toMail)	
	->setEmailFormat('html')
	->setSubject($mailInfo['subject'])
	->setViewVars([
		'message'=> $mailInfo['message']
	])
	->viewBuilder()->setTemplate('send_request_admin');
}
public function send_emp_request($employee, $mailInfo) // Send Request to Employee
{
    $toMail = $employee->user->username;
    if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
        $toMail = 'arundhati.lambore@canqualify.com';
    }
	$this->setTransport('aws_smtp')
	->setFrom(['no-reply@canqualify.com' => 'CanQualify Info'])
	->setBcc(CC_EMAIL)
	->setReplyTo('aaron@canqualify.com')
	->setTo($toMail)
	->setEmailFormat('html')
	->setSubject($mailInfo['subject'])
	->setViewVars([
		'useremail'=> $employee->user->username,
		'message'=> $mailInfo['message']
	])
	->viewBuilder()->setTemplate('send_emp_request');
}
public function send_invoice($contractor, $subject, $message)
{
    $toMail = $contractor->user->username;
    if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
        $toMail = 'arundhati.lambore@canqualify.com';
    }
	$this->setTransport('aws_smtp')
	->setFrom(['no-reply@canqualify.com' => 'CanQualify Info'])
	// ->setBcc(['aaron@canqualify.com'])
	->setBcc(CC_EMAIL)
	->setReplyTo('aaron@canqualify.com')
	->setTo($toMail)
	->setEmailFormat('html')
	->setSubject(sprintf($subject))
	->setViewVars([
        'useremail'=> $contractor->user->username,
		'message' => $message
	])
	->viewBuilder()->setTemplate('send_invoice');
}

public function send_paidInvoice($contractor, $invoice)
{
    $toMail = $contractor->user->username;
    if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
        $toMail = 'arundhati.lambore@canqualify.com';
    }
	$this->setTransport('aws_smtp')
	->setFrom(['no-reply@canqualify.com' => 'CanQualify Info'])
	// ->setBcc(['aaron@canqualify.com', 'developer@mstindia.com'])
	->setReplyTo('aaron@canqualify.com')
	->setTo($toMail)    
	->setEmailFormat('html')
	->setSubject(sprintf('CanQualify - Paid Invoice'))
	->setViewVars([		
		'contractor'=> $contractor,
		'invoice'=>$invoice
	])
	//->setAttachments([IMPORT_INVOICE.'ContractorInvoice_'.$contractor->id.'.pdf'])
	->viewBuilder()->setTemplate('send_paidInvoice');
}
public function reset_password_users($uMail)
{
    $toMail = $uMail['username'];
    if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
        $toMail = 'arundhati.lambore@canqualify.com';
    }    
	$this->setTransport('aws_smtp')
	->setFrom(['no-reply@canqualify.com' => 'CanQualify Info'])
	//->setBcc(CC_EMAIL)
	->setReplyTo('aaron@canqualify.com')
	->setTo($toMail) // add email recipient
	->setEmailFormat('html') // email format
	->setSubject(sprintf('Reset password %s', $uMail['username'])) // subject of email
	->setViewVars([ // these variables will be passed to email template defined in step 5 with name registered.ctp
		'useremail'=> $uMail['username'],
		'password' => $uMail['password'],
		'reseturl' => $uMail['reset_url']
	]) 
	// the template file you will use in this email
	->viewBuilder()->setTemplate('reset_password_users'); // By default template with same name as method name is used.
}

//leads Edit 
public function lead_update($lead=array(), $leadurl, $cr_email,$lead_cr_fullname, $updateBy)
{
	$cc_emails = CC_EMAIL;
    $toMail = $cr_email;
    if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
        $toMail = 'arundhati.lambore@canqualify.com';
    }
	$this->setTransport('aws_smtp')
	->setFrom(['no-reply@canqualify.com' => 'CanQualify Info'])
	->setBcc($cc_emails)
	->setReplyTo('aaron@canqualify.com')
	->setTo($toMail)    
	->setEmailFormat('html')   
	->setSubject(sprintf('Lead Status Update'))
	->setViewVars([
        'cr_name' => $toMail,
		'lead' => $lead,
        'leadurl' => $leadurl,
        'full_name'=>$lead_cr_fullname,
		'updateBy' => $updateBy       
	])
	->viewBuilder()->setTemplate('lead_update');
}



public function send_deactivation_email($contractor, $formdata) 
{
    $toMail = $contractor->user->username;
    if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
        $toMail = 'arundhati.lambore@canqualify.com';
    }
	$this->setTransport('aws_smtp')
	->setFrom(['no-reply@canqualify.com' => 'CanQualify Info'])
	->setBcc(CC_EMAIL)
	->setReplyTo('aaron@canqualify.com')
	->setTo($toMail)
	->setEmailFormat('html')
	->setSubject('Sorry to see you go �� Account Deactivated')
	->setViewVars([
		'contractor'=> $contractor
		
	])
	->viewBuilder()->setTemplate('send_deactivation_email');
}
public function welcome_email_notification($user)
{
    $toMail = $contractor->user->username;
    if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
        $toMail ='arundhati.lambore@canqualify.com';
    }
	$this->setTransport('aws_smtp')
	->setFrom(['no-reply@canqualify.com' => 'CanQualify Info'])
    ->setBcc(['aaron@canqualify.com'])
	->setBcc(CC_EMAIL)
	->setReplyTo('aaron@canqualify.com')
	->setTo($toMail)
	->setEmailFormat('html')
	->setSubject('Welcome Canqualify to your Supplier Portal')
	->setViewVars([
        'user'=> $user->username
		
])
	->viewBuilder()->setTemplate('welcome_email_notification');
}

    public function training_expiring($args = array()) //training_expiring
    {
        $toMail = $args['to_emails'];
        if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
            $toMail = 'arundhati.lambore@canqualify.com';
        }
        $this->setTransport('aws_smtp')
            ->setFrom(['no-reply@canqualify.com' => 'CanQualify Info'])
            ->setBcc(CC_EMAIL)
            ->setReplyTo('support@canqualify.com')
            ->setTo($toMail)
            ->setEmailFormat('html')
            ->setSubject(sprintf('Your %s training "%s" is expiring in a month.', $args['client_company_name'], $args['training_title']))
            ->setViewVars([
                'args'=> $args,
            ])
            ->viewBuilder()->setTemplate('training_expiring');
    }

    public function accountExpiringToday($args = array())
	{
		if(isset($args['to_emails'])){
            $toMail = $args['to_emails'];
		}
        if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
            $toMail = 'arundhati.lambore@canqualify.com';
        }
        $this->setTransport('aws_smtp')
            ->setFrom(['no-reply@canqualify.com' => 'CanQualify'])
            ->setBcc(CC_EMAIL)
            ->setReplyTo('support@canqualify.com')
            ->setTo($toMail)
            ->setEmailFormat('html')
            ->setSubject('URGENT: Account Expires today!')
            ->setViewVars([
                'args'=> $args,
            ])
            ->viewBuilder()->setTemplate('account_expiring_today');
	}

    public function accountExpiring($args = array())
    {
        if(isset($args['to_emails'])){
            $toMail = $args['to_emails'];
        }
        if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] != 'production' ){
            $toMail = 'arundhati.lambore@canqualify.com';
        }
        $supplierName = isset($args['contractor_company_name']) ? $args['contractor_company_name'] : '';
        
        $this->setTransport('aws_smtp')
            ->setFrom(['no-reply@canqualify.com' => 'CanQualify'])
            ->setBcc(CC_EMAIL)
            ->setReplyTo('support@canqualify.com')
            ->setTo($toMail)
            ->setEmailFormat('html')
            ->setSubject($supplierName.'’s account expires soon')
            ->setViewVars([
                'args'=> $args,
            ])
            ->viewBuilder()->setTemplate('account_expiring');
    }
}
?>
