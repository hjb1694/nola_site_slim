<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require "db_connection.php";
require "handle_incoming_input.php";
require "send_contact_mail.php";

function use_router($app, $renderer){

    $app->get('/', function (Request $request, Response $response, $args) {
        global $renderer;
        return $renderer->render($response, 'home.php');
    });
    
    $app->get('/contact', function (Request $request, Response $response) {
        global $renderer;
        return $renderer->render($response, 'contact.php');
    });
    
    $app->get('/request-consultation', function (Request $request, Response $response) {
        global $renderer;
        return $renderer->render($response, 'request_consultation.php');
    });
    
    $app->post('/process-consultation-form', function (Request $request, Response $response) {
        try{

            $body = $request->getParsedBody();

            if(
                !isset($body["full_name"]) ||
                !isset($body["email"]) || 
                !isset($body["phone"]) ||
                !isset($body["prefer_contact_method"]) || 
                !isset($body["best_time_contact"]) || 
                !isset($body["interests"])
            ){
                throw new Exception('Missing Data', 422);
            }

            $full_name_input = handle_incoming_input($body["full_name"]);
            $email_address_input = handle_incoming_input($body["email"]);
            $phone_number_input = handle_incoming_input($body["phone"]);
            $preferred_contact_method = handle_incoming_input($body["prefer_contact_method"]);
            $best_time_contact = handle_incoming_input($body["best_time_contact"]);
            $interest_topics = handle_incoming_input($body["interests"]);

            $conn = db_connection();

            $qry = $conn->prepare("
            INSERT INTO consultation_inquiries(full_name, email, phone_number, preferred_contact_method, best_time_contact, interest_topics) 
            VALUES (?,?,?,?,?,?)
            ");
            $qry->bind_param("ssssss", $full_name_input, $email_address_input, $phone_number_input, $preferred_contact_method, $best_time_contact, $interest_topics);
            $qry->execute();
            $qry->close();
            $conn->close();


            send_contact_mail(
            "Consultation Inquiry", 
            "
            <p>Full Name: $full_name_input</p>
            <p>Email: $email_address_input</p>
            <p>Phone: $phone_number_input</p>
            <p>Preferred Contact Method: $preferred_contact_method</p>
            <p>Best Time to Contact: $best_time_contact</p>
            <p>Topics of Interest: $interest_topics</p>
            "
            );


            $responseData = json_encode(["message" => "created", "body" => $body]);
            $response->getBody()->write($responseData);
            return $response->withHeader('Content-Type','application/json')->withStatus(201);


        }catch(Exception $e){
            $payload = ["error_message" => $e->getMessage()];
            $code = 500;
            if($e->getCode > 400){
                $code = $e->getCode();
            }
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type','application/json')->withStatus($code);
        }
    });

    $app->post('/process-contact-form', function (Request $request, Response $response) {
        try{

            $body = $request->getParsedBody();

            if(
                !isset($body["full_name"]) ||
                !isset($body["email"]) || 
                !isset($body["subject"]) ||
                !isset($body["message_contents"])
            ){
                throw new Exception('Missing Data', 422);
            }

            $full_name_input = handle_incoming_input($body["full_name"]);
            $email_address_input = handle_incoming_input($body["email"]);
            $message_subject_input = handle_incoming_input($body["subject"]);
            $message_contents_input = handle_incoming_input($body["message_contents"]);

            $conn = db_connection();

            $qry = $conn->prepare("INSERT INTO contact_inquiries(full_name, message_subject, email_address, message_contents) VALUES (?,?,?,?)");
            $qry->bind_param("ssss", $full_name_input, $message_subject_input, $email_address_input, $message_contents_input);
            $qry->execute();
            $qry->close();
            $conn->close();


            send_contact_mail(
            "Contact Inquiry",
            "
            <p>Full Name: $full_name_input</p>
            <p>Email: $email_address_input</p>
            <p>Subject: $message_subject_input</p>
            <p>Body:</p>
            <p>$message_contents_input</p>
            "
            );


            $responseData = json_encode(["message" => "created", "body" => $body]);
            $response->getBody()->write($responseData);
            return $response->withHeader('Content-Type','application/json')->withStatus(201);


        }catch(Exception $e){
            $payload = ["error_message" => $e->getMessage()];
            $code = 500;
            if($e->getCode > 400){
                $code = $e->getCode();
            }
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type','application/json')->withStatus($code);
        }
    });

}


?>