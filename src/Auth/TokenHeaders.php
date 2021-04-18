<?php
declare(strict_types=1);

namespace App\Auth;


class TokenHeaders implements TokenHeadersInterface
{
    private $alg;
    private $type;


    /**
     * TokenData constructor.
     * @param array $headers
     * @throws \ReflectionException
     */
    public function __construct(array $headers)
    {
        $this->initialize($headers);
    }

    /**
     * @param array $headers
     * @throws \ReflectionException
     */
    private function initialize(array $headers): void
    {
        $refl = new \ReflectionClass($this);

        $props = $refl->getProperties();

        foreach ($props as $prop){
            if(!isset($headers[$prop->getName()])){
                throw new \RuntimeException("Не передан " .$prop->getName(). " в TokenHeaders");
            }
            $this->{$prop->getName()} = $headers[$prop->getName()];
        }
    }

    /**
     * String representation of object
     * @link https://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     * @throws \ReflectionException
     */
    public function serialize()
    {
        $refl = new \ReflectionClass($this);
        $props = $refl->getProperties();

        $data = [];

        foreach ($props as $prop){
            $data[$prop->getName()] = $this->{$prop->getName()};
        }

        return serialize($data);
    }

    /**
     * Constructs the object
     * @link https://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     * @throws \ReflectionException
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        $refl = new \ReflectionClass($this);
        $props = $refl->getProperties();


        foreach ($props as $prop){
            if(property_exists($this, $prop->getName())){
                $this->{$prop->getName()} = $data[$prop->getName()];
            }
        }
    }

    public function getAlg(): string
    {
        return $this->alg;
    }

    public function getType(): string
    {
        return $this->type;
    }
}