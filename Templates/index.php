<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> Templates </TITLE>
<META NAME="Author" CONTENT="Vinod">
<META NAME="Keywords" CONTENT="Class, Function, Method, Variable">
<META NAME="Description" CONTENT="Naming conventions">
</HEAD>

<BODY>
<table border="0" cellpadding="3" cellspacing="0">
<tr>
    <td>
        <h1>Naming Conventions</h1>
    </td>
</tr>
<tr>
    <td>
        <table border="1" cellpadding="5" cellspacing="5">
            <tr>
                <th>Identifier Type</th>
                <th>Rules for Naming</th>
                <th>Examples</th>
            </tr>
            
            <tr>
                <td>Classes</td>
                <td>Class names should be nouns, in mixed case with the first letter of each internal word capitalized. Try to keep your class names simple and descriptive. Use whole words-avoid acronyms and abbreviations (unless the abbreviation is much more widely used than the long form, such as URL or HTML).</td>
                <td>class Mailer {<br />}<br>
class ImageUpload {<br>
                }</td>
            </tr>
            
            <tr>
                <td>Methods/Functions</td>
                <td>Methods should be verbs, in mixed case with the first letter lowercase, with the first letter of each internal word capitalized</td>
                <td>run();<br>
runFast();<br>
getBackground();</td>
            </tr>
            
            <tr>
                <td>Variables</td>
                <td>Except for variables, all instance, class, and class constants are in mixed case with a lowercase first letter. Internal words start with capital letters. Variable names should not start with underscore _.

Variable names should be short yet meaningful. The choice of a variable name should be mnemonic- that is, designed to indicate to the casual observer the intent of its use. One-character variable names should be avoided except for temporary "throwaway" variables.</td>
                <td>var $a;<br>
public $imageType;</td>
            </tr>
            
            <tr>
                <td>Constants</td>
                <td>The names of constants should be all uppercase with words separated by underscores ("_").</td>
                <td>define("SITE_PATH", "http://ww.example.com/");<br>
define("IMG_MAX_WIDTH", 40);</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td>
        <h1>Templates (Classes & Functions)</h1>
    </td>
</tr>

<tr>
    <td>
        <table border="1" cellpadding="0" cellspacing="0">
            <tr>
                <th>Public Function</th>
            </tr>
            
            <tr>
                <td><?php show_source("public_function.txt")?></td>
            </tr>
            
            <tr>
                <th>Protected Function</th>
            </tr>
            
            <tr>
                <td><?php show_source("protected_function.txt")?></td>
            </tr>
            
            <tr>
                <th>Private Function</th>
            </tr>
            
            <tr>
                <td><?php show_source("private_function.txt")?></td>
            </tr>
            
            <tr>
                <th>Control Class</th>
            </tr>
            
            <tr>
                <td><?php show_source("Control_class_file.txt")?></td>
            </tr>
            
            <tr>
                <th>Facade Class</th>
            </tr>
            
            <tr>
                <td><?php show_source("Facade_class_text.txt")?></td>
            </tr>
            
            <tr>
                <th>Service Class</th>
            </tr>
            
            <tr>
                <td><?php show_source("Service_class_file.txt")?></td>
            </tr>
           
        </table>
    </td>
</tr>

</table>
</BODY>
</HTML>
