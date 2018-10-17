import java.util.Stack;

public class History
{

   
      //Creates Eventish node things ok
      public class Event 
      {
         boolean del; 
         int pos;
         String chg;
         
                   
         public Event(boolean deletion, int position, String Change)
         {
            this.del=deletion;
            this.pos=position;
            this.chg=Change;
         }
      }

   Stack<Event> stack = new Stack<Event>();
   
    /**
       Notepad will call this function when their text changes.

       deletion is a boolean that indicates if the action was a deletion of text or the insertion of text.
       position is the postion where the change took place
       Change is the string of characters that is the change.
     */
   public void addEvent(boolean deletion, int position, String Change)
   {
      boolean del = deletion;
      int pos = position;
      String chg = Change; 
      
      Event event = new Event(del,pos,Change);
      
      
      stack.push(event);
      
   }                                                         

    /**
       Notepad will call this function when it wishes to undo the last event.

       note is a variable to the Notepad that called this function
     */
   public void undoEvent(NotePad note)
   {  
      Event event = stack.pop();
 
      
      if (event.del==true)
      {//if something was deleted 
         note.insert(event.pos, event.chg);
      }
      else
      {//if something was added
         int length=event.chg.length();
         
         note.remove(event.pos, length);
      }
   }

      
    /**
       Notepad will call this function when it wishes to redo the last event that was undone.
       Note that new actions should clear out events that can be "redone"
       note is a variable to the Notepad that called this function
     */
   public void redoEvent(NotePad note)
   {
   	
   }

    /**
       returns true if there is undo data in the History
     */
   public boolean hasUndoData()
   {
       if (stack.empty()==true)
       {
         return false;
       }
       else
       {
         return true;
       }
   }

    /**
       returns true if there is undo data in the History
     */
   public boolean hasReDoData()
   {
       return false;
   }
	

}
