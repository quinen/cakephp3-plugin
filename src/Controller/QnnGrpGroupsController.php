<?php
namespace Quinen\Controller;

use Quinen\Controller\AppController;

/**
 * QnnGrpGroups Controller
 *
 * @property \Quinen\Model\Table\QnnGrpGroupsTable $QnnGrpGroups
 *
 * @method \Quinen\Model\Entity\QnnGrpGroup[] paginate($object = null, array $settings = [])
 */
class QnnGrpGroupsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $qnnGrpGroups = $this->paginate($this->QnnGrpGroups);

        $this->set(compact('qnnGrpGroups'));
        $this->set('_serialize', ['qnnGrpGroups']);
    }

    /**
     * View method
     *
     * @param string|null $id Qnn Grp Group id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $qnnGrpGroup = $this->QnnGrpGroups->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('qnnGrpGroup', $qnnGrpGroup);
        $this->set('_serialize', ['qnnGrpGroup']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $qnnGrpGroup = $this->QnnGrpGroups->newEntity();
        if ($this->request->is('post')) {
            $qnnGrpGroup = $this->QnnGrpGroups->patchEntity($qnnGrpGroup, $this->request->getData());
            if ($this->QnnGrpGroups->save($qnnGrpGroup)) {
                $this->Flash->success(__('The qnn grp group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The qnn grp group could not be saved. Please, try again.'));
        }
        $this->set(compact('qnnGrpGroup'));
        $this->set('_serialize', ['qnnGrpGroup']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Qnn Grp Group id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $qnnGrpGroup = $this->QnnGrpGroups->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $qnnGrpGroup = $this->QnnGrpGroups->patchEntity($qnnGrpGroup, $this->request->getData());
            if ($this->QnnGrpGroups->save($qnnGrpGroup)) {
                $this->Flash->success(__('The qnn grp group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The qnn grp group could not be saved. Please, try again.'));
        }
        $this->set(compact('qnnGrpGroup'));
        $this->set('_serialize', ['qnnGrpGroup']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Qnn Grp Group id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $qnnGrpGroup = $this->QnnGrpGroups->get($id);
        if ($this->QnnGrpGroups->delete($qnnGrpGroup)) {
            $this->Flash->success(__('The qnn grp group has been deleted.'));
        } else {
            $this->Flash->error(__('The qnn grp group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
