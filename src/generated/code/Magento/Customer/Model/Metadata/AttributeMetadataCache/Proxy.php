<?php
namespace Magento\Customer\Model\Metadata\AttributeMetadataCache;

/**
 * Proxy class for @see \Magento\Customer\Model\Metadata\AttributeMetadataCache
 */
class Proxy extends \Magento\Customer\Model\Metadata\AttributeMetadataCache implements \Magento\Framework\ObjectManager\NoninterceptableInterface
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Proxied instance name
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Proxied instance
     *
     * @var \Magento\Customer\Model\Metadata\AttributeMetadataCache
     */
    protected $_subject = null;

    /**
     * Instance shareability flag
     *
     * @var bool
     */
    protected $_isShared = null;

    /**
     * Proxy constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     * @param bool $shared
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Magento\\Customer\\Model\\Metadata\\AttributeMetadataCache', $shared = true)
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
        $this->_isShared = $shared;
    }

    /**
     * @return array
     */
    public function __sleep()
    {
        return ['_subject', '_isShared', '_instanceName'];
    }

    /**
     * Retrieve ObjectManager from global scope
     */
    public function __wakeup()
    {
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    }

    /**
     * Clone proxied instance
     */
    public function __clone()
    {
        if ($this->_subject) {
            $this->_subject = clone $this->_getSubject();
        }
    }

    /**
     * Debug proxied instance
     */
    public function __debugInfo()
    {
        return ['i' => $this->_subject];
    }

    /**
     * Get proxied instance
     *
     * @return \Magento\Customer\Model\Metadata\AttributeMetadataCache
     */
    protected function _getSubject()
    {
        if (!$this->_subject) {
            $this->_subject = true === $this->_isShared
                ? $this->_objectManager->get($this->_instanceName)
                : $this->_objectManager->create($this->_instanceName);
        }
        return $this->_subject;
    }

    /**
     * {@inheritdoc}
     */
    public function load($entityType, $suffix = '')
    {
        return $this->_getSubject()->load($entityType, $suffix);
    }

    /**
     * {@inheritdoc}
     */
    public function save($entityType, array $attributes, $suffix = '')
    {
        return $this->_getSubject()->save($entityType, $attributes, $suffix);
    }

    /**
     * {@inheritdoc}
     */
    public function clean()
    {
        return $this->_getSubject()->clean();
    }

    /**
     * Reset state of proxied instance
     */
    public function _resetState() : void
    {
        if ($this->_subject) {
            $this->_subject->_resetState(); 
        }
    }
}
