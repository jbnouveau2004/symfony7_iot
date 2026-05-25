<?php
namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;


use App\Entity\Admin;
use App\Form\AdminType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminController extends AbstractController
{

    /**
     * @var Environment
     */
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function admin_home(): Response
    {
        $admin = $this->getUser()->getUsername();
        return new Response($this->twig->render('admin/home.html.twig', [
            'admin' => $admin
        ]));
    }

    public function infos(): Response
    {
        return $this->render('admin/infos.html.twig');
    }

    public function guide(): Response
    {
        return $this->render('admin/guide.html.twig');
    }

    public function utilisateurs(ManagerRegistry $doctrine): Response
    {
        $admin = $this->getUser()->getUsername();
        $var_utilisateurs_array = $doctrine->getRepository(Admin::class)->findAll();
        return new Response($this->twig->render('admin/utilisateurs.html.twig', [
            'utilisateurs' => $var_utilisateurs_array,
            'admin' => $admin
        ]));
    }

    public function utilisateurs_new(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        if ($this->getUser()->getRoles()[0]!="ROLE_ADMIN") {
            return new Response('Vous n\'êtes pas autorisé à rentrer dans cette page');
        }
        $var_utilisateurs = new Admin();
        $form = $this->createForm(AdminType::class, $var_utilisateurs);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $nom_entitee = $doctrine->getManager();

            //encodage du mot de passe
            $var_utilisateurs->setPassword(
                $passwordHasher->hashPassword($var_utilisateurs, $var_utilisateurs->getPassword())
            );
            //définition du role
            $role = ['ROLE_USER'];
            $var_utilisateurs->setRoles($role);

            $nom_entitee->persist($var_utilisateurs);
            $nom_entitee->flush();
            $this->addFlash('success', 'L\'utilisateur a bien été ajouté');
            return $this->redirectToRoute('utilisateurs');
        }

        return new Response($this->twig->render('admin/utilisateurs_new.html.twig', [
            'form' => $form->createView()
        ]));
    }

    public function utilisateurs_edit(ManagerRegistry $doctrine, $id, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $var_utilisateur = $doctrine->getRepository(Admin::class)->find($id);
        $form = $this->createForm(AdminType::class, $var_utilisateur);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $nom_entitee = $doctrine->getManager();
            //encodage du mot de passe
            $var_utilisateur->setPassword(
                $passwordHasher->hashPassword($var_utilisateur, $var_utilisateur->getPassword())
            );
            $nom_entitee->persist($var_utilisateur);
            $nom_entitee->flush();
            $this->addFlash('success', 'L\'utilisateur a bien été modifié');
            return $this->redirectToRoute('utilisateurs');
        }

        return new Response($this->twig->render('admin/utilisateurs_edit.html.twig', [
            'utilisateurs' => $var_utilisateur,
            'form' => $form->createView()
        ]));

    }

    public function utilisateurs_delete(ManagerRegistry $doctrine, $id, Request $request): Response
    {
        if ($this->getUser()->getRoles()[0]!="ROLE_ADMIN") {
            return new Response('Vous n\'êtes pas autorisé à rentrer dans cette page');
        }
        if($this->isCsrfTokenValid('delete'.$id , $request->get('_token')))
        {
            $var_utilisateur = $doctrine->getRepository(Admin::class)->find($id);
            $nom_entitee = $doctrine->getManager();
            $nom_entitee->remove($var_utilisateur);
            $nom_entitee->flush();
            $this->addFlash('success', 'L\'utilisateur a bien été supprimé');
            return $this->redirectToRoute('utilisateurs');
        }
        return $this->redirectToRoute('utilisateurs');
    }
}