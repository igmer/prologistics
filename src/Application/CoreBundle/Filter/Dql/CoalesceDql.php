<?php
/*
 *  COALESCE
 *      Evalúa los argumentos en orden y devuelve el valor actual de la primera
 *      expresión que inicialmente no se evalúa como NULL.
 *
 *  DBMS Soportados | Documentación
 *  ----------------+-----------------------------------------------------------
 *      PostgreSql  |   http://www.postgresql.org/docs/9.1/static/functions-conditional.html
 *      SQLServer   |   https://msdn.microsoft.com/es-es/library/ms190349(v=sql.120).aspx
 *      Oracle      |   https://docs.oracle.com/cd/B28359_01/server.111/b28286/functions023.htm
 *      MySql       |   http://dev.mysql.com/doc/refman/5.7/en/comparison-operators.html#function_coalesce
 *
 *  CoalesceFunction ::= "COALESCE" "(" ArithmeticPrimary "," ArithmeticPrimary "," ... "," ArithmeticPrimary(n) ")"
 */
namespace Application\CoreBundle\Dql;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

class CoalesceDql extends FunctionNode {

    public  $values   = array();

    public function parse(\Doctrine\ORM\Query\Parser $parser) {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        // Agregando el primer parámetro al array de valores.
        $this->values[] = $parser->ArithmeticExpression();

        // Agregando el resto de parámetro a el array. COALESCE debe de
        // ser usado con almenos 2 parametros.
        $lexer = $parse->getLexer();
        while( count($this->values) < 2 || $lexer->lookahead['type'] == Lexer::T_COMMA ) {
            $parser->match(Lexer::T_COMMA);
            $peek = $lexer->glimpse();
            $this->values[] = $peek['value'] == '('
                    ? $parser->FunctionDeclaration()
                    : $parser->ArithmeticExpression();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker) {
        // Creando el array que contendrá los elementos de la consulta.
        $queryBuilder = array('COALESCE(');

        // Iterando los elementos capturados en la expresión y agregandolos a la consulta.
        for ($i = 0; $i < count($this->values); $i++) {
            if ($i > 0) {
                $queryBuilder[] = ', ';
            }

            // Ejecutando el Dispatch del Walker en la posición actual.
            $nodeSql        = $sqlWalker->walkArithmeticPrimary($this->values[$i]);
            $queryBuilder[] = $nodeSql;
        }

        // Cerrando el parantesis de la función.
        $queryBuilder[] = ')';

        // Retornado la consulta unida.
        return implode('', $queryBuilder);
    }
}
