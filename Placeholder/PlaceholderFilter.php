<?php

namespace Ibnab\Bundle\PmanagerBundle\Placeholder;

use Doctrine\Common\Util\ClassUtils;

use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Ibnab\Bundle\PmanagerBundle\Provider\ConfigurationProvider;
use Oro\Bundle\EntityExtendBundle\Tools\ExtendHelper;

class PlaceholderFilter
{
    /** @var ConfigurationProvider */
    protected $configProvider;

    /** @var DoctrineHelper */
    protected $doctrineHelper;

    /**
     * @param ConfigurationProvider $configProvider
     * @param DoctrineHelper $doctrineHelper
     */
    public function __construct(
        ConfigurationProvider $configProvider,
        DoctrineHelper $doctrineHelper
    ) {
        $this->configProvider = $configProvider;
        $this->doctrineHelper       = $doctrineHelper;
    }
    public function getAllowedSection()
    {
        $values['allowed'] = [];
        return $values;
    }
    /**
     * @param object $entity
     * @return bool
     */
    public function isApplicable($entity)
    {
        if (!is_object($entity)
            || !$this->doctrineHelper->isManageableEntity($entity)
            || $this->doctrineHelper->isNewEntity($entity)
        ) {
            return false;
        }

        $allowedSection = $this->getAllowedSection();
        $className = ClassUtils::getClass($entity);
        $allowedSection = $allowedSection['allowed'];
        foreach ($allowedSection as $allowedValue) {
            if ($allowedValue === $className) {
                return true;
            }
        }
        
        return false;
    }
}
