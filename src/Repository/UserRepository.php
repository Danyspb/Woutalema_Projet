<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }


    /**
     * @return array
     * Retourne une liste d'utilisateur pour l'API
     *
     */
    public function apiFindAll(): array
    {
         $sql = $this->createQueryBuilder('u')
             ->select('u.id', 'u.nom','u.prenom','u.telephone','u.numero_cni')
             ->orderBy('u.nom', 'DESC');

         $query = $sql->getQuery();
         return $query->execute();

    }

    public function finAllAdmin(): array
    {
        return $this->createQueryBuilder('u')
            ->Where('u.roles LIKE :roles')
            ->setParameter('roles', '%"'.'ROLE_ADMIN'.'"%')
            ->orderBy('u.roles', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function finAllPrestataire(): array
    {
        return $this->createQueryBuilder('u')
            ->Where('u.roles like :role')
            ->setParameter('role', '%"'.'ROLE_PRESTATAIRE'.'"%')
            ->orderBy('u.roles', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function finAllLivreur(): array
    {
        return $this->createQueryBuilder('u')
            ->Where('u.roles like :role')
            ->setParameter('role', '%"'.'ROLE_LIVREUR'.'"%')
            ->orderBy('u.roles', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function finAllClient(): array
    {
        return $this->createQueryBuilder('u')
            ->Where('u.roles like :role')
            ->setParameter('role', '%"'.'ROLE_CLIENT'.'"%')
            ->orderBy('u.roles', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
