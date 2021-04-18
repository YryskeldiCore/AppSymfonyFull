<?php
declare(strict_types=1);

namespace App\Files\Repository;


use App\Files\Model\File;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileRepository extends ServiceEntityRepository implements FileRepositoryInterface
{

    private $manager;

    public function __construct(ManagerRegistry $registry, ObjectManager $manager)
    {
        parent::__construct($registry, File::class);
        $this->manager = $manager;
    }

    /**
     * @param File $file
     * @return File
     */
    public function save(File $file): File
    {
        $this->manager->persist($file);
        $this->manager->flush();

        return $file;
    }

    /**
     * @param string $hash
     * @return File
     */
    public function oneByHash(string $hash): File
    {
        /** @var File $file */
        $file =  parent::findOneBy(['hash' => $hash]);

        if($file == null){
            throw new NotFoundHttpException("Файл не найден");
        }

        return $file;

    }

    /**
     * @param int $id
     * @return bool
     */
    public function remove(int $id): bool
    {
        /** @var File|null $file */
        $file = parent::find($id);

        if($file == null){
            throw new NotFoundHttpException("Файл не найден");
        }

        $this->manager->remove($file);

        return true;

    }
}