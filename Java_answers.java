import java.util.*;

public class MyClass {
    public static void main(String args[]) {
      // Create an array to test the function that returns missing number in an array
      int[] testArray ={5,4,2,1};
      // call the function that returns the missing number in an array
      int missingNumber = getMisingNumber(testArray);
      
      // Display the missing number
      if( missingNumber != 0){
          System.out.println("Misisng number: " + missingNumber);
      }else{
          System.out.println("No missing number"); 
      }
      
      // Create a test string to be reversed
      String test = " Tempor ip";
      // Display the reversed string
      System.out.println("Reversed String: " + reverseString(test));
      
    }

    /**
     * A function that returns missing number in an array
     * @param numbersArray The array which has one missing integer
     */
    private static int getMisingNumber(int[] numbersArray){
        int missingNumber = 0;
        //sort the array
        Arrays.sort(numbersArray);
        
        try{
            for(int i = 0; i < numbersArray.length; i++){
                // If number at index[i]+1 is not equal to number at index[i+1]
                // then the missing number is the value of index[i]+1
                if( (numbersArray[i] + 1 == numbersArray[i+1]) && ( (i+1) < numbersArray.length)  ){
                    continue;
                }else{
                   missingNumber = numbersArray[i] + 1;
                   break;
                }
            }
        }catch(ArrayIndexOutOfBoundsException e){
            missingNumber = 0;
        }
        return missingNumber;
    }

    /**
     * A function that reverses the elements of a string
     * @param originalString The string to be reversed
     */
    private static String reverseString(String originalString){
        int lengthOfString = originalString.length();
        // Calculat the number of sub strings that can be made for originalString
        int numberOfSubstrings =  ( (lengthOfString + 4) - 1) / 4;
        // String array to hold the substrings
        String[] subStrings = new String[numberOfSubstrings];

        int beginIndex= 0;
        int i = 0;
        while (i < numberOfSubstrings)
        {
            // Creating substring of length 4 from originalString
            if( (beginIndex + 4) < lengthOfString){
                subStrings[i] = originalString.substring(beginIndex, beginIndex + 4);
            }else{
                subStrings[i] = originalString.substring(beginIndex, lengthOfString);
            }
            
            beginIndex += 4;
            i++;
        }

     // Loop through each sub string,
     // Create an array of characters from the substring
     // then reversed the order of the characters
     int x = 0;
     while( x< subStrings.length){
        int subStringLegth = subStrings[x].length();
        char[] characterArray = new char[subStringLegth];
        // Create a character array to from the sub string at index[i]
        characterArray = subStrings[x].toCharArray();
         
        char[] b = new char[characterArray.length]; 
        int j = characterArray.length; 
        // loop throught the characterArray and reverse the order of the characters
        for (int r = 0; r < characterArray.length; r++) { 
            b[j - 1] =characterArray[r]; 
            j = j - 1; 
        } 
        
        // initialize the sub string at index[i] to the reversed character array
        subStrings[x] = String.valueOf(b);
        //incremet counter
         x++;
     }

     StringBuilder reversedString  = new StringBuilder(""); 
     int y = 0;
     // Loop through the reversed sub strings and append them
     // to the string builder to create one string
     while( y < subStrings.length){
         reversedString.append(subStrings[y]);
         //increment the counter
         y++;
     }
     
     return reversedString.toString();
    }
}