<?php
class Latest_tutorial extends Controller
{
    public function index()
    {
        $data['style'] = BASEURL . '/css/latest-tutorial-style.css';
        $data['style-tutorial'] = BASEURL . '/css/tutorial-style.css';
        $data['script-modal-detail-tutorial'] = BASEURL . '/js/script-modal-detail-tutorial.js';
        $data['script-axios'] = 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js';
        $data['script-load-more'] = BASEURL . '/js/script-load-more.js';
        $data['tutorials'] = $this->model('Home_model')->getTutorials();
        $data['total-tutorials'] = $this->model('Home_model')->getTotalTutorials();


        $twig = $this->view();

        echo $twig->render(
            '/templates/header.html.twig',
            [
                'style' => $data['style'],
                'style_tutorial' => $data['style-tutorial'],
                'BASEURL' => BASEURL,
                'login_teacher' => $_SESSION['login_teacher'] ?? false,
                'login_student' => $_SESSION['login_student'] ?? false,
                'username_teacher' => $_SESSION['username_teacher'] ?? '',
                'username_student' => $_SESSION['username_student'] ?? ''
            ]
        );

        echo $twig->render('/latest-tutorial/index.html.twig');

        // echo $twig->render(
        // 	'/tutorial/student-non-dashboard.html.twig',
        // 	[
        // 		'tutorials' => $data['tutorials'],
        // 		'total_tutorials' => $data['total-tutorials'],
        // 		'BASEURL' => BASEURL
        // 	]
        // );

        if (isset($_SESSION['login_teacher'])) {

            echo $twig->render(
                '/tutorial/bases/tutorial-complete.html.twig',
                [
                    'tutorials' => $data['tutorials'],
                    'total_tutorials' => $data['total-tutorials'],
                    'BASEURL' => BASEURL
                ]
            );
        } elseif (isset($_SESSION['login_student'])) {

            // nanti di sini muncul view kumpulan tutorial yg ada tombol purchase aja
            echo "ini view student";
        } else {
            // nanti di sini muncul view kumpulan tutorial yg ada tombol purchase aja
            // klu tombol purchase di klik nanti minta login dulu sebagai student
            // echo "ini view kosong";
            // jika setelah di lakukan fuzzy search tapi semua hasil nya dalam is_revoke = Y
            // maka tampilkan no tutorial view
            echo empty($data['tutorials'])
                ? $twig->render('/tutorial/no-tutorial.html.twig') :
                $twig->render(
                    '/tutorial/main-tutorial.html.twig',
                    [
                        'tutorials' => $data['tutorials'],
                        'total_tutorials' => $data['total-tutorials'],
                        'BASEURL' => BASEURL
                    ]
                );
        }

        echo $twig->render(
            '/templates/footer.html.twig',
            [
                'script_axios' => $data['script-axios'],
                'script_modal_detail_tutorial' => $data['script-modal-detail-tutorial'],
                'script_load_more' => $data['script-load-more'],
                'BASEURL' => BASEURL
            ]
        );
    }
}
