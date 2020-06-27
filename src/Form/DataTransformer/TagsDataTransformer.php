<?php
/**
 * Tags data transformer.
 */

namespace App\Form\DataTransformer;

use App\Entity\Tags;
use App\Repository\TagsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class TagsDataTransformer.
 */
class TagsDataTransformer implements DataTransformerInterface
{
    /**
     * Tag repository.
     *
     */
    private TagsRepository $repository;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    /**
     * TagsDataTransformer constructor.
     * @param TagsRepository $repository
     * @param EntityManagerInterface $manager
     */
    public function __construct(TagsRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * Transform array of tags to string of names.
     *
     * @param Collection $tags Tags entity collection
     *
     * @return string Result
     */
    public function transform($tags): string
    {
        if (null == $tags) {
            return '';
        }

        $tagNames = [];

        foreach ($tags as $tag) {
            $tagNames[] = $tag->getTitle();
        }

        return implode(',', $tagNames);
    }

    /**
     * Transform string of tag names into array of Tag entities.
     *
     * @param string $value String of tag names
     *
     * @return array Result
     *
     */
    public function reverseTransform($value): array
    {
        $tagTitles = explode(',', $value);

        $tags = [];

        foreach ($tagTitles as $tagTitle) {
            if ('' !== trim($tagTitle)) {
                $tag = $this->repository->findOneBy(['title' => strtolower($tagTitle)]);
                if (null == $tag) {
                    $tag = new Tags();
                    $tag->setTitle($tagTitle);
                    $tag->setCreatedAt(new \DateTime());
                    $tag->setSlug($tagTitle);
                    $this->manager->persist($tag);
                    $this->manager->flush();
                }
                $tags[] = $tag;
            }
        }

        return $tags;
    }
}