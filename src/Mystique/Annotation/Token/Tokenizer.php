<?php

namespace Mystique\Annotation\Token;

use Mystique\Common\Token\Tokenizer as ITokenizer;

class Tokenizer implements ITokenizer {
    protected $simpleTokens = array(
        '(', ')', '=', ',', '@', '{', '}', '[', ']', '^', '~', '|'
    );

    protected $patterns = array(
        'name'          => '[a-zA-Z_]\w*',
        'whitespace'    => '\s+',
        'number'        => '(0x[0-9a-fA-F]|[0-9]*\.[0-9]+|[0-9]+)',
    );

    /**
     * @return \Mystique\Common\Token\TokenStream
     */
    function getTokens($source)
    {
        $tokens = array();
        $i = 0;
        while(strlen($source) > 0) {
            if(in_array($source{0}, $this->simpleTokens)) {
                $tokens[]= new \Mystique\Common\Token\Token($source[0]);
                $source = substr($source, 1);
                continue;
            } else {
                foreach($this->patterns as $type => $pattern) {
                    if(preg_match("/$pattern/A", $source, $m)) {
                        $tokens[]= new \Mystique\Common\Token\Token(array($type, $m[0]));
                        $source = substr($source, strlen($m[0]));
                        continue 2;
                    }
                }
            }
            if($source{0} == '"') {
                $ptr = 1;
                $str = '"';
                while($source{$ptr} != '"') {
                    if($source{$ptr} == '\\') {
                        switch($source{$ptr}) {
                            case "n": $str .= "\n"; break;
                            case "r": $str .= "\r"; break;
                            case "t": $str .= "\t"; break;
                            case '\\': $str .= "\\"; break;
                            case '"': $str .= '"'; break;
                            default:
                                throw new \UnexpectedValueException("Invalid escape sequence near {$source}");
                        }
                    } else {
                        $str .= $source{$ptr};
                    }
                    $ptr ++;
                }
                $str .= '"';
                $tokens[] = new \Mystique\Common\Token\Token(array('string', $str));
                $source = substr($source, $ptr +1);
                continue;
            }
            throw new \UnexpectedValueException("Unexpected input near {$source}");
        }
        return $tokens;
    }
}