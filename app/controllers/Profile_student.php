<?php
class Profile_student extends Controller
{
    public function viewProfile(string $username = "")
    {
        if (!$this->model('Verify_model')->isUserLogin()) {

            header('Location: ' . BASEURL . '/Login/student');
            exit;
        }

        if (!$this->model('Verify_model')->isLoginAsStudent()) return $this->model('Verify_model')->goHome();
        if ($_SESSION["username_student"] != stripslashes(htmlspecialchars(strtolower($username)))) return $this->model('Verify_model')->goHome();

        $data['profile-student'] = $this->model('Profile_student_model')->getProfileInfoBy($_SESSION["username_student"]);
        if (empty($data['profile-student'])) return $this->model('Verify_model')->goHome();


        $data['style'] = BASEURL . '/css/profile-student-style.css';
        $data['script'] = BASEURL . '/js/script-profile.js';
        $twig = $this->view();
        echo $twig->render(
            '/templates/header.html.twig',
            [
                'style' => $data['style'],
                'BASEURL' => BASEURL,
                'login_teacher' => $_SESSION['login_teacher'] ?? false,
                'login_student' => $_SESSION['login_student'] ?? false,
                'username_teacher' => $_SESSION['username_teacher'] ?? '',
                'username_student' => $_SESSION['username_student'] ?? ''
            ]
        );

        echo $twig->render(
            '/profile/student.html.twig',
            [
                'profile_student' => $data['profile-student'],
                'flash' => Flasher::flash() ?? '',
                'BASEURL' => BASEURL

            ]
        );

        echo $twig->render('/templates/footer.html.twig', ['script' => $data['script'], 'BASEURL' => BASEURL]);
    }

    public function changePassword()
    {
        if (!$this->model('Verify_model')->isLoginAsStudent()) return $this->model('Verify_model')->goHome();
        $result = $this->model('Profile_student_model')->changePassword($_POST);
        Flasher::setFlash($result['icon'], $result['title'], $result['text']);
        header('Location: ' . BASEURL . '/Profile_student/viewProfile/' . $_SESSION["username_student"]);
        exit;
    }

    public function editProfilePic()
    {
        if (!$this->model('Verify_model')->isLoginAsStudent()) return $this->model('Verify_model')->goHome();
        $result = $this->model('Profile_student_model')->editProfilePic($_POST);
        Flasher::setFlash($result['icon'], $result['title'], $result['text']);
        header('Location: ' . BASEURL . '/Profile_student/viewProfile/' . $_SESSION["username_student"]);
        exit;
    }
}
