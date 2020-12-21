<?php


namespace App\Action;


use App\Entity\ValuationRequest;
use App\Service\staffService;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use Slim\Flash\Messages as FlashMessages;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Slim\Http\UploadedFile;

final class StaffAction extends BaseAction
{
    private $view;
    private $logger;
    private $staffService;
    private $entityManager;
    private $flash;


    public function __construct(Twig $view, LoggerInterface $logger, staffService  $staffService,EntityManager $entityManager, FlashMessages $flash) {
        $this->view = $view;
        $this->logger = $logger;
        $this->staffService = $staffService;
        $this->entityManager = $entityManager;
        $this->flash = $flash;

    }
    public function __invoke(Request $request, Response $response, $args) {

        $this->view->render($response, 'staff-dashboard.twig');
        return $response;
    }


    public function valuationRequest(Request $request, Response $response) {

        $valuers = $this->staffService->fetchvaluers(null);
        $this->view->render($response, 'valuations/request-valuation.twig',
            [
                'valuers' => $valuers
            ]);
        return $response;

    }

    public function manageRequests(Request $request, Response $response)
    {
        $staff = $this->staffService->fetchStaff($_SESSION['user']);
        $valuations = $this->staffService->fetchstaffvaluations($staff);
        $this->view->render($response, 'valuations/valuer-requests.twig',
            [
                'valuations' => $valuations
            ]);
        return $response;
    }

    public function saveRequest(Request $request, Response $response) {


        $client_name=$request->getParam('client_name');
        $client_phone=$request->getParam('client_phone');
        $vehicle_reg=$request->getParam('vehicle_reg');
        $vehicle_model=$request->getParam('vehicle_model');
        $vehicle_make=$request->getParam('vehicle_make');
        $valuer=$request->getParam('valuer');
        $logbook=$request->getParam('logbook');
        $comments=$request->getParam('comments');
        $status='Pending';
        $user=$_SESSION['user'];

        $valuers = $this->staffService->fetchvaluers($valuer);
        $staff = $this->staffService->fetchStaff($user);
        $uploadedFiles = $request->getUploadedFiles();

        // handle single input with single file upload
        $uploadedFile = $uploadedFiles['logbook'];
        if (empty($uploadedFile)) {
            throw new Exception('No file has been send');
        }
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {

            $filename =$this->moveUploadedFile('../uploads/', $uploadedFile);
            $response->write('uploaded ' . $filename . '<br/>');

        }

        $valuation=new ValuationRequest();
        $valuation->setClientName($client_name);
        $valuation->setClientPhone($client_phone);
        $valuation->setVehicleReg($vehicle_reg);
        $valuation->setVehicleMake($vehicle_make);
        $valuation->setVehicleModel($vehicle_model);
        $valuation->setValuerID($valuers);
        $valuation->setLogBook($filename);
        $valuation->setValuationStatus($status);
        $valuation->setDateRequested(new \DateTime());
        $valuation->setDateUpdated(new \DateTime());
        $valuation->setRequester($staff);
        $valuation->setComment($comments);

        $save = $this->staffService->storeValuationRequest($valuation);

        if($save)
        {
            $body='Kindly provide a valuation for the vehicle attached herein on behalf of our client <br> Mwananchi Credit';
            //Send email to Valuer
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
              //  $mail->Host       = 'mail.uptronafrica.com ';                    // Set the SMTP server to send through
             //   $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            //    $mail->Username   = 'julius.gitonga@uptronafrica.com';                     // SMTP username
           //     $mail->Password   = 'Uptron20!9';                               // SMTP password
             //   $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
               // $mail->Port       = 26;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                $mail->Host="smtp.gmail.com";
                $mail->Port=587;
                $mail->SMTPSecure="tls";
                $mail->SMTPAuth=true;
                $mail->Username="uptronafrica@gmail.com";
                $mail->Password="Uptron20!9";

                //Recipients
                $mail->setFrom('uptronafrica@gmail.com', 'Mwananchi Credit');
                $mail->addAddress('juliusgitonga2013@gmail.com', 'Julius Gitonga');     // Add a recipient
                $mail->addAddress('julius.gitonga@uptronafrica.com');               // Name is optional
                $mail->addReplyTo('info@mwananchicredit.com', 'Information');
               // $mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');

                // Attachments
               // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
               // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Vehicle Valuation Request';
                $mail->Body    = $body;
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();

            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
        return $response->withRedirect('/staff/manage-requests');


    }



    //Function to send mail,
    function sendVerificationEmail($email,$id)
    {
        $mail = new PHPMailer;

        $mail->SMTPDebug=3;
        $mail->isSMTP();

        $mail->Host="smtp.gmail.com";
        $mail->Port=587;
        $mail->SMTPSecure="tls";
        $mail->SMTPAuth=true;
        $mail->Username="uptronafrica@gmail.com";
        $mail->Password="Uptron20!9";

        $mail->addAddress($email,"User Name");
        $mail->Subject="Verify Your Email Address For StackOverFlow";
        $mail->isHTML();
        $mail->Body=" Welcome to StackOverFlow.<b><b> Please verify your email adress to continue..";
        $mail->From="SocialCodia@gmail.com";
        $mail->FromName="Social Codia";

        if($mail->send())
        {
            echo "Email Has Been Sent Your Email Address";
        }
        else
        {
            echo "Failed To Sent An Email To Your Email Address";
        }


    }
    public function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}