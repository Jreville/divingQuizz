<?php 

namespace App\Form;
use Symfony\Component\Form\DataTransformerInterface;

class JsonToStringTransformer implements DataTransformerInterface
{
    public function transform($value) : mixed
    {
        // Transform JSON array to string for form submission
        return json_encode($value);
    }

    public function reverseTransform($value) : mixed
    {
        
        // Transform string to JSON array after form submission
        return json_decode($value, true);
    }
}

