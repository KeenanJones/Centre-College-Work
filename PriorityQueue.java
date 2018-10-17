import java.util.Comparator;

public class PriorityQueue<T> extends Queue<T>
{

   Comparator<T> comp;
   int count;

   public PriorityQueue(Comparator<T> comp)
   {
      this.comp = comp;
      this.count=0; 
   }


    //@Override
   public void push(T val)
   {  
       //super.push(val); //right now this is just a normal Queue as it will do what its parent did.
      if (count==0)
         {
            Node n = new Node(val, null);
            front=n;
            back=n;
         }
      if (count==1)
      {
         Node f = back;
         System.out.println(f.tobj);
         if (comp.compare(val,f.tobj)==1 || comp.compare(val,f.tobj)==0)
         {
            Node n = new Node(val,f);
            front = n;
            back = f;
         }
         else
         {
            Node n = new Node(val,null);
            f.next = n;
            back = n;
         }
      }
      if (count>=2)
      {
         Node past = front;
         Node curr = front.next;
         int timesin = 0;
         int ichange = 0;
         if (comp.compare(val,past.tobj)==1)
         {
            Node n = new Node(val,past);
            front = n;
            ichange++;
         }
         for (int i=1; i<this.count; i++)
         {
          if ((comp.compare(val,curr.tobj)==0 || comp.compare(val, curr.tobj)==1) && timesin==0 && ichange==0)
          {
            
            Node n = new Node(val,curr);
            past.next = n;
            timesin++;   
          }
                    
         
         
         past = past.next;
         curr = curr.next;
         }
       if (timesin==0 && ichange==0)
       {
       Node n = new Node(val , null);
       past.next = n;
       }
       }  
    this.count++;   
   }

   public T pop()
   {
      if (front!= null)
       {
           T store = front.tobj;
           front = front.next;
           this.count --;
           return store; 
       }
       else
       {
         throw new QueueUnderFlowException(); 
       }

   }
}
